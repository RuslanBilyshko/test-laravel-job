<?php namespace App\Modules\Forms;


use App\Modules\Content\ContentController;

class Forms extends ContentController {

  protected static $form = [
		'id' => null,
		'method' => 'post',
    'enctype' => null,
		'action' => null,
		'fields' => [],
		'data' => [],
		'class_wrapper' => null,
		];

		protected static $field = [
			'id' => 'idfield',
			'class' => 'form-control',
			'field_width' => null,
			'label' => NULL,
			'label_class' => null,
			'label_hide' => false,
			'placeholder' => null,
			'required' => true,
			'disabled' => false,
			'selected' => NULL,
			'type' => 'text',
			'value' => '',
			'data' => [],
			'size' => '',
			'fields' => NULL,
			'cols' => 60,
			'rows' => 5,
			'description' => NULL,
			'button_size' => null,
			'onclick' => null,
		];

	protected $button = [];

	public static function get($options = array())
	{
		$options = array_merge(self::$form, $options);

    if($options['enctype'] == 'file')
        $options['enctype'] = 'multipart/form-data';

		if($options['data'])
		{
			$fields = [];
			foreach($options['data'] as $opt)
			{
				if(is_object($opt))
					$fields[] = $opt;
				else
					$fields[] = self::field($opt);
			}
			$options['fields'] = $fields;
		}
			return self::render('form',$options);
	}

	public static function field($options = array())
	{
		$options = array_merge(self::$field, $options);

		if(($options['type'] == 'submit' || $options['type'] == 'button'))
		{
			if($options['class'] == 'form-control')
			{
				$options['class'] = 'btn btn-default';
			}
			else
			{
				$options['class'] = 'btn btn-'.$options['class'];
				if($options['button_size'])
					$options['class'] = $options['class'].' btn-'.$options['button_size'];
			}
		}

		if($options['field_width'])
			$options['field_width'] = 'col-md-'.$options['field_width'];
		else
			$options['field_width'] = 'col-md-12';

			if($options['label_hide'])
			$options['label_class'] .= ' sr-only';

			$options['field'] = self::render($options['type'],$options);

			//if(($options['type'] == 'submit' || $options['type'] == 'button') || $options['type'] == 'hidden')
			if($options['type'] == 'hidden')
				return $options['field'];
			else
				return self::render('field',$options);
  }

	public static function selectForNumber($selected = null)
	{
		$data = [];
		for($i = 1; $i <= 31; $i++)
		{
			if($i < 10)
				$day = '0'.$i;
			else
				$day = $i;

			$data[$i] = $day;
		}

		return self::field([
			'id' => 'number',
			'type' => 'select',
			'label' => trans('app.number'),
			'data' => $data,
			'selected' => $selected,
			'required' => false,
			'field_width' => 3,
		]);
	}

	public static function selectForMonth($selected = null)
	{
		$data = [];

		for($i = 0; $i < 12; $i++)
		{
			$data[$i+1] = trans('months.'.$i);
		}

		return self::field([
			'id' => 'month',
			'type' => 'select',
			'label' => trans('app.month'),
			'data' => $data,
			'selected' => $selected,
			'required' => false,
			'field_width' => 5,
		]);
	}

	public static function selectForYear($selected = null)
	{
		$data = [];

		for($i = 1970; $i < 2005; $i++)
		{
			$data[$i] = $i;
		}

		return self::field([
			'id' => 'year',
			'type' => 'select',
			'label' => trans('app.year'),
			'data' => $data,
			'selected' => $selected,
			'required' => false,
			'field_width' => 4,
		]);
	}

	public static function label($text)
	{
		return view()->file(__DIR__.'/templates/label.blade.php',['text' => $text]);
	}

  public static function buttonLogin($options = array())
  {
    $options = array_merge(self::$field, $options);

    return $fields[] = Forms::field([
      'id' => 'login',
      'type' => 'submit',
      'value' => $options['value'] ? $options['value'] : trans('app.getLogin'),
      'class' => 'primary',
      'disabled' => $options['disabled'] ? 'disabled' : null,
    ]);
  }

  public static function buttonRegister($options = array())
  {
    $options = array_merge(self::$field, $options);

    return $fields[] = Forms::field([
      'id' => 'register',
      'type' => 'submit',
      'value' => $options['value'] ? $options['value'] : trans('app.getRegister'),
      'class' => 'primary',
      'disabled' => $options['disabled'] ? 'disabled' : null,
    ]);
  }

	public static function buttonAdd($options = array())
	{
		$options = array_merge(self::$field, $options);

		return $fields[] = Forms::field([
			'id' => 'add',
			'type' => 'submit',
			'value' => $options['value'] ? $options['value'] : trans('app.add'),
			'class' => 'primary',
			'disabled' => $options['disabled'] ? 'disabled' : null,
		]);
	}

	public static function buttonSave($options = array())
	{
		$options = array_merge(self::$field, $options);

		return $fields[] = Forms::field([
			'id' => 'save',
			'type' => 'submit',
			'value' => $options['value'] ? $options['value'] : trans('app.save'),
			'class' => 'success',
			'disabled' => $options['disabled'] ? 'disabled' : null,
		]);
	}

	public static function buttonReserved($options = array())
	{
		$options = array_merge(self::$field, $options);

		return $fields[] = Forms::field([
			'id' => 'reserved',
			'type' => 'submit',
			'value' => $options['value'] ? $options['value'] : trans('app.reserv'),
			'class' => 'warning',
			'disabled' => $options['disabled'] ? 'disabled' : null,
		]);
	}

	public static function buttonPrint($options = array())
	{
		$options = array_merge(self::$field, $options);

		return $fields[] = Forms::field([
			'id' => 'print',
			'type' => $options['type'] ? $options['type'] : 'button',
			'value' => $options['value'] ? $options['value'] : trans('app.print'),
			'class' => 'info',
			'onclick' => $options['onclick'] ? $options['onclick'] : null,
			'disabled' => $options['disabled'] ? 'disabled' : null,
		]);
	}

	public static function buttonUpdate($options = array())
		{
			$options = array_merge(self::$field, $options);
			//button update
			return Forms::field([
				'id' => 'update',
				'type' => 'submit',
				'value' => $options['value'] ? $options['value'] : trans('app.update'),
				'class' => 'primary',
				'size' => null
			]);
		}

	public static function buttonCancel($options = array())
	{
		$options = array_merge(self::$field, $options);
		//button cancel
		return Forms::field([
			'id' => 'cancel',
			'type' => 'submit',
			'value' => $options['value'] ? $options['value'] : trans('app.cancel'),
		]);
	}

	public static function buttonDelete($options = array())
	{
		$options = array_merge(self::$field, $options);

		return $fields[] = Forms::field([
			'id' => 'delete',
			'type' => 'submit',
			'value' => $options['value'] ? $options['value'] : trans('app.delete'),
			'class' => 'danger',
		]);
	}

	private static function render($tpl,$options)
	{
		$options = array_merge(self::$form, $options);

		if($tpl == 'text' || $tpl == 'file' || $tpl == 'button' || $tpl == 'submit' || $tpl == 'hidden' || $tpl ==
			'password' || $tpl == 'email')
			$tpl = 'text';

    return view()->file(__DIR__.'/templates/'.$tpl.'.blade.php', $options);
	}


}