<?php namespace App\Modules\Content;


class Field extends ContentController implements iContent
{
  public $name;
  public $value;
  public $label = null;

  public function paragraf($text)
  {
    return $this->view('paragraf',['text' => $text]);
  }

  public function render()
  {
    return $this->view('field',[
      'name' => $this->name,
      'value' => $this->value,
      'label' => $this->label,
    ]);
  }
}