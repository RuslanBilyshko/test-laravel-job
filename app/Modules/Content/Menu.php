<?php namespace App\Modules\Content;

use Illuminate\Http\Request;

class Menu extends ContentController implements iContent
{
  private $request;
  private $class_menu;
  private $title_menu;
  private $items = [];
  private $item = [
    'access' => 'guest',
    'href' => '#',
    'title' => null,
    'text' => 'Item menu',
    'class' => 'item-menu',
  ];

  public function __construct($request)
  {
    $this->request = $request;
  }

  public function setClassMenu($class)
  {
    $this->class_menu = $class;
  }

  public function setTitleMenu($title)
  {
    $this->title_menu = $title;
  }

  public function setItem($options = [])
  {
    $item = array_merge($this->item, $options);
    $currentURL = $this->request->url();

    if($item['href'] == $currentURL)
      $item['class'] .= ' active';

    if(empty($item['title']))
      $item['title'] = $item['text'];

      $this->items[] = $item;
  }

  public function render()
  {
    $data['class_menu'] = $this->class_menu;
    $data['items'] = $this->items;
    return $this->view('menu',$data);
  }
}