<?php namespace App\Http\Controllers;

use App\Http\Requests\Request;
use App\Modules\Content\Menu;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Session;

abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;

  protected $site_name;
  private $scripts = [];
  private $styles = [];
  protected $head_title = null;
  protected $title;
  private $content =  [];
  private $footer;

  public function __construct()
  {
    $this->site_name = $this->title = trans('app.testLaravel');
    $this->title = trans('app.pageTitle');

  }

  protected function addScript()
  {

  }

  protected function addContent($content)
  {
    $this->content[] = $content;
  }

  /**
   * @return \Illuminate\View\View
   */
  public function draw()
  {
    if(empty($this->head_title))
      $this->head_title = $this->title;

    return view('tpl.page',[
      'site_name' => $this->site_name,
      'scripts' => $this->scripts,
      'styles' => $this->styles,
      'head_title' => $this->head_title,
      'title' => $this->title,
      'content' => $this->content,
      'footer' => $this->footer,
    ]);
  }


}
