<?php namespace App\Modules\Content;

class Block extends ContentController implements iContent
{
  private $fields = [];

  public function __construct()
  {
    $this->classes = 'block';
  }

  public function addField($field)
  {
    $this->fields[] = $field;
  }

  public function render()
  {
    $data = [];

    if(!empty($this->title))
      $data['title'] = $this->title;

    if(!empty($this->classes))
      $data['classes'] = $this->classes;

    $data['fields'] = $this->fields;

    return $this->view('block',$data);
  }

  public static function make($data, $title = null, $class = null)
  {
    $render = [];
    foreach ($data as $key => $value) {
      $field = new Field();
      $field->name = $field->label = $key;
      $field->value = $value;
      $render[] = $field->render();
    }

    $res['title'] = $title;
    $res['classes'] = $class;
    $res['fields'] = $render;

    return view()->file(__DIR__.'/templates/block.blade.php',$res);
  }

}