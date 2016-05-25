<?php
if ( ! function_exists('render')) {

  /**
   * @param $items
   */
  function render($items)
  {
    if(is_array($items))
    {
      foreach($items as $item)
        echo $item;
    }

  }
}

if ( ! function_exists('renderLink')) {

  /**
   * @param $items
   */
  function renderLink($link, $args = array())
  {
    $defaultArg = [
      'id' => null,
      'text' => NULL,
      'title' => NULL,
      'class' => NULL,
      'ajax' => false,
      'size' => NULL,
      'type' => NULL,
      'dataAjax' => null,
      'disabled' => false,
    ];

    $args = array_merge($defaultArg, $args);

    empty($args['text']) ? $text = $link : $text = $args['text'];

    if($args['title'])
      $args['title'] = 'title="'.$args['title'].'"';

    if($args['class'] && $args['class'] != 'link')
      $args['class'] = 'btn btn-'.$args['class'];
    elseif(empty($args['class']))
      $args['class'] = 'btn btn-default';

    if($args['size'])
      $args['class'] .= ' btn-'.$args['size'];

    if($args['type'])
      $args['type'] = 'type="'.$args['type'].'"';

    if($args['id'])
      $args['id'] = 'id="'.$args['id'].'"';

    if($args['ajax'])
    {
      $args['dataAjax'] = 'data-ajax';
      $args['class'] .= ' ajaxPopup';
    }

    if($args['disabled'])
    {
      $args['class'] .= ' disabled';
    }

    $link = '<a '.$args['dataAjax'].' '.$args['id'].' href="'.$link.'" class="'.$args['class'].'" '.$args['title'].' '.$args['type'].'>'.$text.'</a>';
    return $link;
  }
}
if ( ! function_exists('setMessage'))
{
  function setMessage($text,$status = true)
  {
    if($status)
      $message_status = 'success';
    else
      $message_status = 'danger';

    Session::flash('message', $text);
    Session::flash('message_status', $message_status);
  }
}

