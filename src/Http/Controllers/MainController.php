<?php namespace VivifyIdeas\AdminPanelGenerator\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller {


    public function index($tableName, Request $request)
    {
        $filters = $request->except('page', 'direction', 'column');

        $direction = 'asc';
        if ($request->has('direction')) {
            if ($request->get('direction') == 'asc') {
                $direction = 'desc';
            }
        }

        $column = $request->get('column', 'id');

        return packageView('main.index', [
            'tableName' => $tableName,
            'columns' => packageConfig('columns.' . $tableName),
            'rows' => $this->applyFilter($filters, $tableName)->orderBy($column, $direction)->paginate(packageConfig('rowsPerPage')),
            'filters' => packageConfig('filters.' . $tableName),
            'filterValue' => $filters,
            'direction' => $direction,
            'orderColumn' => $column,
            'sortHref' => '/' . $request->path() . '?' . http_build_query(array_merge($filters, [ 'direction' => $direction ]))
        ]);
    }

    private function applyFilter(array $filters, $tableName)
    {
        $q = \DB::table($tableName);

        if (empty($filters)) {
            return $q;
        }

        $filterOptions = packageConfig('filters.' . $tableName);

        foreach ($filters as $name => $value) {
            if (!empty($value)) {
                $filter = @$filterOptions[$name]['compare'];
                if (!$filter) {
                    $filter = '=';
                }

                $q->where($name, $filter, $this->prepareFilterValue($filter, $value));
            }
        }

        return $q;
    }

    public function delete($tableName, $id)
    {
        \DB::table($tableName)->where('id', $id)->delete();

        return redirect()->back();
    }

    public function create($tableName)
    {
        $form = $this->getForm($tableName);

        return packageView('main.create', [
            'tableName' => $tableName,
            'form' => $form,
            'belongsTo' => $this->getBelongsToColumns($form),
            'hasMany' => $this->getHasManyColumns($form)
        ]);
    }

    private function getForm($tableName)
    {
        $form = packageConfig('forms.' . $tableName);
        foreach ($form as $key => &$value) {
            if (is_numeric($key)) {
                $form[$value] = [ 'label' => ucfirst($value), 'type' => 'text' ];
                unset($form[$key]);
            }
        }
        return $form;
    }

    private function getBelongsToColumns($form)
    {
        $belongsTo = null;

        if (@$form['belongsTo']) {
            foreach ($form['belongsTo'] as $table => $options) {
                $belongsTo[$table] = \DB::table($table)->orderBy($options['foreignLabel'], 'asc')->lists($options['foreignLabel'], 'id');
                if (@$options['nullable']) {
                    $belongsTo[$table] = ['' => 'None'] + $belongsTo[$table];
                }
            }
        }

        return $belongsTo;
    }

    private function getHasManyColumns($form)
    {
        $hasMany = null;

        if (@$form['hasMany']) {
            foreach ($form['hasMany'] as $table => $options) {
                $hasMany[$table] = \DB::table($table)->orderBy($options['foreignLabel'], 'asc')->lists($options['foreignLabel'], 'id');
                if (@$options['nullable']) {
                    $hasMany[$table] = ['' => 'None'] + $hasMany[$table];
                }
            }
        }

        return $hasMany;
    }

    private function getSelectedHasManyColumns($form, $id)
    {
        $selectedHasMany = null;

        if (@$form['hasMany']) {
            foreach ($form['hasMany'] as $table => $options) {
                $selectedHasMany[$table] = \DB::table($table)->where($options['column'], $id)->lists('id');
            }
        }

        return $selectedHasMany;
    }

    public function edit($tableName, $id)
    {
        $form = $this->getForm($tableName);

        return packageView('main.edit', [
            'entity' => \DB::table($tableName)->where('id', $id)->first(),
            'tableName' => $tableName,
            'form' => $form,
            'belongsTo' => $this->getBelongsToColumns($form),
            'hasMany' => $this->getHasManyColumns($form),
            'selectedHasMany' => $this->getSelectedHasManyColumns($form, $id)
        ]);
    }

    private function parseInputData($request)
    {
        $data = $request->except(['_token', '_method']);
        foreach ($data as $key => &$value) {
            if ($value == '') {
                $value = null;
            }
        }
        return $data;
    }

    public function update($tableName, $id, Request $request)
    {
        $this->validate($request, packageConfig('validationRules.' . $tableName));

        $data = $this->parseInputData($request);

        if (\Schema::hasColumn($tableName, 'updated_at')) {
            $data['updated_at'] = \Carbon\Carbon::now();
        }

        $hasMany = null;

        if (@$data['hasMany']) {
            $hasMany = $data['hasMany'];
            unset($data['hasMany']);
        }

        \DB::table($tableName)->where('id', $id)->update($data);

        $form = $this->getForm($tableName);

        if (isset($form['hasMany'])) {
            foreach ($form['hasMany'] as $table => $options) {
                \DB::table($table)->where($options['column'], $id)->update([$options['column'] => null ]);

                $ids = $hasMany[$table];
                if ($ids) {
                    \DB::table($table)->whereIn('id', $ids)->update([ $options['column'] => $id ]);
                }
            }
        }

        return redirect(packageConfig('prefix') . '/' . $tableName);
    }

    public function store($tableName, Request $request)
    {
        $this->validate($request, packageConfig('validationRules.' . $tableName));

        $data = $this->parseInputData($request);

        if (\Schema::hasColumn($tableName, 'created_at')) {
            $data['created_at'] = \Carbon\Carbon::now();
            $data['updated_at'] = $data['created_at'];
        }

        $hasMany = null;

        if (@$data['hasMany']) {
            $hasMany = $data['hasMany'];
            unset($data['hasMany']);
        }

        $id = \DB::table($tableName)->insertGetId($data);

        if ($hasMany) {
            $form = $this->getForm($tableName);
            foreach ($hasMany as $table => $ids) {
                \DB::table($table)->whereIn('id', $ids)->update([ $form['hasMany'][$table]['column'] => $id ]);
            }
        }

        return redirect(packageConfig('prefix') . '/' . $tableName);
    }

}
