<?php namespace App\Modules\Content;


use ReflectionClass;

abstract class ContentController
{
  protected $tplDir = 'templates';
  protected $tplExt = '.blade.php';
  protected $classes;

  /**
   * Инициализация классов для обертки
   * @param null $className
   */
  public function addClass($className = null)
  {
    if($className)
      $this->classes .= ' '.$className;
  }

  /**
   * Возвращает путь к директории с шаблонами текущего класса-потомка
   * @return string
   */
  private function getPath()
  {
    $cl = new ReflectionClass(get_class($this));
    $filePath = $cl->getFileName();
    $exp = explode('\\',$filePath);
    array_pop($exp);

    $path = '';

    for($i = 0; $i < count($exp); $i++)
    {
      $path .= $exp[$i].'\\';
    }

    return $path;
  }

  /**
   * @param $tplName
   * @param array $params
   * @return mixed view
   */
  protected function view($tplName,$params = array())
  {
    $currDir = $this->getPath();
    $tplPath = $this->tplDir;
    $tplExt = $this->tplExt;

    return view()->file($currDir.$tplPath.'/'.$tplName.$tplExt, $params);
  }



}