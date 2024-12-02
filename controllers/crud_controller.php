<?php

include_once 'framework/inflector.php';

class CrudController extends AppController {

    public
    $paths = array(
        'model' => 'models/',
        'controller' => 'controllers/',
        'view' => 'views/app/'
            ),
    $conventions = array(
        'model' => '%s.php',
        'controller' => '%s_controller.php',
        'view' => '%s_%s.tpl'
            ),
    $display_fields = array(
        'name', 'title'
    );
    private
    $table_name = '',
    $table_structure = null,
    $table_relations = array(),
    $table_meta = array();

    private function get_meta($table) {

        $class = strtolower(Inflector::singularize($table));
        if ($this->table_name != $table) {
            $table_structure = $this->table_structure($table);
        } else {
            $table_structure = $this->table_structure;
        }

        $displayable = $this->display_fields;
        $displayable[] = $class;
        $display_field = 'id';

        foreach ($table_structure as $col) {
            if (in_array($col['Field'], $displayable)) {
                $display_field = $col['Field'];
                break;
            }
        }

        return array(
            'class' => ucfirst($class),
            'table' => strtolower($table),
            'lower' => $class,
            'display' => $display_field
        );
    }

    public function gen() {

        $this->set_theme('crud');
        if (func_num_args() == 0) {
            return false;
        }

        $relations = func_get_args();
        $this->table = array_shift($relations);
        $structure = $this->table_structure($this->table);

        foreach ($structure as &$col) {

            if (strpos($col['Type'], 'int') !== false) {
                $col['Type'] = 'int';
            }

            if (strpos($col['Type'], 'varchar') !== false) {
                $col['Type'] = 'varchar';
            }

            if (strpos('date', $col['Type']) !== false) {
                $col['Type'] = 'date';
            }

            if (strpos($col['Type'], 'text') !== false) {
                $col['Type'] = 'text';
            }

            if (strpos($col['Type'], 'bool') !== false) {
                $col['Type'] = 'bool';
            }

            if ($col['Field'] == 'image') {
                $folder = 'media/' . $this->table;
                if (!is_dir($folder)) {
                    mkdir($folder, 0777);
                }
            }

            $this->table_structure[] = $col;
        }
        $this->set('tablestructure', $this->table_structure);
        $this->table_meta = $this->get_meta($this->table);
        $this->set('meta', $this->table_meta);


        foreach ($relations as $relation) {
            $this->table_relations[] = $this->get_meta($relation);
        }
        var_dump($this->table_relations);
        $this->set('relations', $this->table_relations);
        $this->gen_view();
        $this->gen_model();
        $this->gen_controller();
        exit();
    }

    private function gen_model() {
        $model = $this->template->fetch('model.tpl');
        $this->put_contents('model', $model);
    }

    private function gen_controller() {
        $controller = $this->template->fetch('controller.tpl');
        $this->put_contents('controller', $controller);
    }

    private function gen_view() {

        $view = $this->template->fetch('view_index.tpl');
        $this->put_contents('view', $view, 'index');

        $int_validation = '';

        foreach ($this->table_structure as $structure) {
            if ($structure['Type'] == 'int' && strpos($structure['Field'], '_id') === false) {
                $int_validation .= "'{$structure['Field']}',";
            }
        }
        $int_validation = rtrim($int_validation, ',');

        $this->set('int_validation', strlen($int_validation) > 0 ? $int_validation : false);

        $view = $this->template->fetch('view_add.tpl');
        $this->put_contents('view', $view, 'add');
    }

    private function put_contents($type, $out, $extra='') {
        file_put_contents($this->paths[$type] . sprintf($this->conventions[$type], $this->table_meta['lower'], $extra), $out);
    }

    private function table_structure($table) {
        return Database::query('SHOW COLUMNS FROM `' . $table.'`')->fetch_all();
    }

}

?>