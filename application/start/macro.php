<?php

/**
 * Create a HTML input element.
 *
 * @param  string  $type
 * @param  string  $name
 * @param  mixed   $value
 * @param  mixed   $valueLabel
 * @param  array   $attributesInput
 * @param  array   $attributesLabel
 * @return string
 */
Form::macro('nginput', function($type, $name, $value = null, $valueLabel = null, $attributesInput = array(), $attributesLabel = array())
{
    $html = '<div class="formRow">';
    $html .= '<div class="grid3">';

    //label
    $html .= Form::label($name, $valueLabel, $attributesLabel);

    $html .= '</div>';
    $html .= '<div class="grid9">';

    //input
    $html .= Form::input($type, $name, $value, $attributesInput);

    $html .= '</div>';
    $html .= '<div class="clear"></div>';
    $html .= '</div>';
    return $html;

});


/**
 * Create a HTML select element.
 *
 * @param  string  $name
 * @param  mixed   $options
 * @param  mixed   $selected
 * @param  mixed   $valueLabel
 * @param  array   $attributesInput
 * @param  array   $attributesLabel
 * @return string
 */
Form::macro('nyelect', function($name, $options = array(), $selected = null, $valueLabel = null, $attributesInput = array(), $attributesLabel = array())
{
    $html = '<div class="formRow">';
    $html .= '<div class="grid3">';

    //label
    $html .= Form::label($name, $valueLabel, $attributesLabel);

    $html .= '</div>';
    $html .= '<div class="grid9">';

    //input
    $html .= Form::select($name, $options, $selected, $attributesInput);

    $html .= '</div>';
    $html .= '<div class="clear"></div>';
    $html .= '</div>';
    return $html;

});


/**
 * Create a HTML select element.
 *
 * @param  string  $name
 * @param  mixed   $value
 * @param  mixed   $checked
 * @param  mixed   $valueLabel
 * @param  mixed   $valueInsideLabel
 * @param  array   $attributesInput
 * @param  array   $attributesLabel
 * @return string
 */
Form::macro('nyheckbox', function($name, $value = null, $checked = false, $valueLabel = null, $valueInsideLabel = null, $attributesInput = array(), $attributesLabel = array())
{
    $html = '<div class="formRow">';
    $html .= '<div class="grid3">';

    //label
    $html .= Form::label($name, $valueLabel, $attributesLabel);

    $html .= '</div>';
    $html .= '<div class="grid9 check">';

    //input
    $html .= Form::checkbox($name, $value, $checked, $attributesInput);
    $html .= '<label class="mr20">'. $valueInsideLabel .'</label>';

    $html .= '</div>';
    $html .= '<div class="clear"></div>';
    $html .= '</div>';
    return $html;
});


/**
 * return name or description of given access_type code
 * @param string $code
 * @return string
 */
HTML::macro('access_type', function($code) {
    if($code == 'M')
        return 'Main Navigation';
    elseif($code == 'S')
        return 'Sub Navigation';
    else
        return 'Access Link';
});

/**
 *
 */
HTML::macro('main_nav', function() {
    $mainActive = Session::get('active.main.nav');
    $html = '';
    foreach(Auth::navigation() as $menu) {
        $html .= '<li><a href="';
        $html .= URL::to_action($menu['action']);
        $html .= '"';
        if($menu['action'] == $mainActive) {
            $html .= 'class="active"';
        }
        $html .= '><span>';
        $html .= $menu['title'];
        $html .= '</span></a></li>';
    }
    echo $html;

//    $navigation = array(
//        'home' => array(
//            'action' => 'role@index',
//            'name' => 'Blog',
//            'active' => 0
//        ),
//        'cat' => array(
//            'action' => 'home@categoryIndex',
//            'name' => 'Categorie',
//            'active' => 0
//        ),
//        'bout' => array(
//            'action' => 'home@about',
//            'name' => 'About',
//            'active' => 0
//        ),
//    );
//    $c = URI::current();
//    var_dump($c);
//    $a = str_replace('/', '@', $c);
//    var_dump($a);
//    foreach($navigation as $n) {
//        var_dump($n['action'] . ' ~ ' .$a);
//        if($n['action'] == $a) {
//            var_dump('granted');
//            break;
//        }
//    }

});