<?php

class {$meta.class}Controller extends AppController {ldelim}

	private $per_page = 100;

	function index($page=0) {ldelim}
	
{if count($relations)}
		$this->set(array(
			{section name=inst loop=$relations}'{$relations[inst].table}' => {$relations[inst].class}::find(array('fields'=>'id{if $relations[inst].display neq 'id'}, {$relations[inst].display}{/if}'))->fetch_all(){if $smarty.section.inst.last neq true},{/if}

{/section}
		));

{/if}
		$filter = 'TRUE';
		if(array_key_exists('search', $_GET)) {ldelim}
			$filter = " (id = '{ldelim}$_GET['search']{rdelim}'{if $meta.display neq 'id'} OR {$meta.display} like '%{ldelim}$_GET['search']{rdelim}%' {/if})";
		{rdelim}
		$limit = ($page * $this->per_page) .' , ' .$this->per_page;
		
		${$meta.table} = {$meta.class}::find(array( 'where' => $filter))->fetch_all();
		$total_{$meta.table} = {$meta.class}::count(array('where' => $filter));
		
		$this->set(array(
			'{$meta.table}' => ${$meta.table},
			'total_{$meta.table}' => $total_{$meta.table} ,
			'per_page' => $this->per_page,
			'page' => $page
		));
		
	{rdelim}
	
	function add(${$meta.lower}_id = 0) {ldelim}
	
{if count($relations)}
		$this->set(array(
			{section name=inst loop=$relations}'{$relations[inst].table}' => {$relations[inst].class}::find(array('fields'=>'id{if $relations[inst].display neq 'id'}, {$relations[inst].display}{/if}'))->fetch_all(){if $smarty.section.inst.last neq true},{/if}

{/section}
		));

{/if}
		${$meta.lower} = new {$meta.class}(${$meta.lower}_id);
		if(!${$meta.lower}->id && ${$meta.lower}_id) {ldelim}
			$this->redirect("{$meta.lower}");
		{rdelim}
		
        if(array_key_exists('data', $_POST)) {ldelim}

            ${$meta.lower}->update_map($_POST['data']);

            if( ${$meta.lower}->validate() ) {ldelim}
				if(!${$meta.lower}->id) {ldelim}
					${$meta.lower}->insert();
				{rdelim} else {ldelim}
					${$meta.lower}->update();
				{rdelim}
{section name=inst loop=$tablestructure}
{if $tablestructure[inst].Field eq 'image'}

				if(($image = $this->_upload($_FILES['uploadedfile'])->do_upload('media/{$meta.table}/','{$meta.table}_'.${$meta.lower}->id{if $meta.display neq 'id'}.slug(${$meta.lower}->{$meta.display}){/if}, array('png','jpg','jpeg','gif'))) !== false ) {ldelim}            
                    $this->_image()->resize($image, 500, 500);
                    {$meta.class}::edit(array('image' => basename($image)), 'id = '. ${$meta.lower}->id);
                {rdelim}
				
{/if}
{/section}
                $this->redirect('{$meta.lower}?success=1');
            {rdelim} else {ldelim}
                $this->set('data',$_POST['data']);
                $this->set('invalid',1);
            {rdelim}

        {rdelim} else {ldelim}
            $this->set('data', ${$meta.lower}->to_array());
        {rdelim}
	{rdelim}
	
	function edit(${$meta.lower}_id = 0) {ldelim}
		if(${$meta.lower}_id == 0) {ldelim}
			$this->redirect("{$meta.lower}");
		{rdelim}
		$this->set_view('{$meta.lower}_add');
		$this->add(${$meta.lower}_id);
	{rdelim}
	
	function delete(${$meta.lower}_id) {ldelim}
		{$meta.class}::delete(${$meta.lower}_id);
		$this->redirect('referer');
	{rdelim}
	
	function delete_selected() {ldelim}
		if(array_key_exists('id', $_POST)) {ldelim}
			if(is_array($_POST['id'])) {ldelim}
				$this->delete(array_keys($_POST['id']));
			{rdelim}
		{rdelim}
	{rdelim}
	
{section name=inst loop=$tablestructure}
{if $tablestructure[inst].Field eq 'enabled'}
	function enable(${$meta.lower}_id = 0) {ldelim}
		${$meta.lower} = new {$meta.class}(${$meta.lower}_id);
		if(!${$meta.lower}->id) {ldelim}
			$this->redirect("${$meta.lower}");
		{rdelim}
		${$meta.lower}->enabled = !${$meta.lower}->enabled;
		${$meta.lower}->update();
		$this->redirect('referer');
	{rdelim}
{/if}
{/section}

{if count($relations)}
{section name=inst loop=$relations}
	function update_{$relations[inst].lower}(${$meta.lower}_id = 0, ${$relations[inst].lower}_id = 0) {ldelim}
		${$meta.lower} = new {$meta.class}(${$meta.lower}_id);
		if(!${$meta.lower}->id) {ldelim}
			exit();
		{rdelim}
		${$meta.lower}->{$relations[inst].lower}_id = ${$relations[inst].lower}_id;
		${$meta.lower}->update();
		exit();
	{rdelim}
{/section}
{/if}
{rdelim}
?>