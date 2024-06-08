<?php

use App\Models\Categories;
use App\Models\Options;

if (!function_exists('option')) {
    function option($option_name = '')
    {
        if (!empty($option_name)) {
            $option = Options::where('option_name', $option_name)->first();
            if ($option) {
                return $option->option_value;
            }
        }
        return 20;
    }
}
if (!function_exists('group_user')) {
    function group_user($group_value = '')
    {
        if (!empty($group_value)) {
            foreach (Config::get('auth.group_users') as $key => $value) {
                if ($key == $group_value) {
                    return $value;
                }
            }
        }
        return null;
    }
}
if (!function_exists('tab_level')) {
    function tab_level($category = null)
    {
        $level = Categories::levelCategory($category->parent_id, 0);
        return '- ' . str_repeat('- ', $level);
    }
}
if (!function_exists('select_categories')) {
    function select_categories($categories = null, $currentParent_id = 0)
    {
        $select = '<select class="uk-width-1-1" name="parent_id" id="parent_id">';
        $select .= '<option value="0"> -Chọn nhóm cha- </option>';
        foreach ($categories as $category) {
            $select .= '<option value="' . $category->id . '" ' . ($category->id == $currentParent_id ? "selected" : "") . '>' . tab_level($category) . ' ' . $category->name . '</option>';
        }
        $select .= '</select>';
        echo $select;
    }
}
if (!function_exists('menu_items')) {
    function menu_items($menuItems = null, $parent_id = 0)
    {
        echo ($parent_id > 0) ? '<ul class="uk-nestable-list">' : '';
        foreach ($menuItems as $item) {
            echo '<li class="uk-nestable-item" data-id="' . $item->id . '" data-name="' . $item->name . '" data-type="' . $item->type . '" 
            data-type_id="' . $item->type_id . '" data-class="' . $item->class . '"  data-rel="' . $item->rel . '" data-url="' . $item->url . '">
            <div class="uk-nestable-panel">
						<i class="uk-nestable-handle uk-icon uk-icon-bars uk-margin-small-right"></i> <span>' . $item->name . '</span>
						<button class="uk-button uk-button-mini uk-accordion-toggle uk-float-right" type="button">
							<i class="uk-icon-chevron-down"></i>
						</button>
					</div>
                    <div class="uk-accordion-content uk-form-horizontal uk-margin-top">
						<div class="uk-form-row">
							<label class="uk-form-label">Tiêu đề</label>
							<div class="uk-form-controls">
								<input  class="uk-width-1-2 name_menu" type="text" name="" value="' . $item->name . '">
							</div>
						</div>
						<div class="uk-form-row">
							<label class="uk-form-label">URL</label>
							<div class="uk-form-controls">
								<input class="uk-width-1-2 url_menu" type="text" name="" value="' . $item->url . '" ' . (($item->type != 'options') ? 'readonly' : '') . '>
							</div>
						</div>
						<div class="uk-form-row">
							<label class="uk-form-label">Class</label>
							<div class="uk-form-controls">
								<input class="uk-width-1-2 class_menu" type="text" name="" value="' . $item->class . '">
							</div>
						</div>
						<div class="uk-form-row">
							<label class="uk-form-label">Rel</label>
							<div class="uk-form-controls">
								<input class="uk-width-1-2 rel_menu" type="text" name="" value="' . $item->rel . '">
							</div>
						</div>
						<div class="uk-form-row">' . Config::get('app.menu_types.' . $item->type) . '</div>
                        <div class="uk-form-row">
							<label class="uk-form-label">Target</label>
							<div class="uk-form-controls">
								<label>
									<input type="checkbox" class="target_menu" value="1" > Cửa sổ mới
								</label>
							</div>
						</div>
						<div class="uk-form-row">
							<button type="button" class="uk-button uk-button-link remove-menu"><i class="uk-icon-close"></i> Xóa bỏ</button>
						</div>
					</div>
            ';
            if ($item->children->count() > 0) {
                menu_items($item->children, $item->id);
            }
            echo '</li>';
        }
        echo ($parent_id > 0) ? '</ul>' : '';
    }
}
if (!function_exists('menu_categories')) {
    function menu_categories($extension)
    {
        $categories = Categories::getTree($extension, 0);
        if (count($categories) > 0) {
            foreach ($categories as $category) {
                $level = Categories::levelCategory($category->parent_id, 0);
                echo str_repeat('&emsp;', $level) . '<input type="checkbox" data-name="' . $category->name . '" data-type_id="'.$category->id.'" data-url="'.$category->slug.'"> ' . $category->name . '<br>';
            }
        }
    }
}
