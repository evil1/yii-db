<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\jui;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * DatePicker renders an datepicker jQuery UI widget.
 *
 * For example:
 *
 * ```php
 * echo DatePicker::widget([
 *     'language' => 'ru',
 *     'model' => $model,
 *     'attribute' => 'country',
 *     'clientOptions' => [
 *         'dateFormat' => 'yy-mm-dd',
 *     ],
 * ]);
 * ```
 *
 * The following example will use the name property instead:
 *
 * ```php
 * echo DatePicker::widget([
 *     'language' => 'ru',
 *     'name'  => 'country',
 *     'clientOptions' => [
 *         'dateFormat' => 'yy-mm-dd',
 *     ],
 * ]);
 *```
 *
 * @see http://api.jqueryui.com/datepicker/
 * @author Alexander Kochetov <creocoder@gmail.com>
 * @since 2.0
 */
class DatePicker extends InputWidget
{
	/**
	 * @var string the locale ID (eg 'fr', 'de') for the language to be used by the date picker.
	 * If this property set to false, I18N will not be involved. That is, the date picker will show in English.
	 */
	public $language = false;
	/**
	 * @var boolean If true, shows the widget as an inline calendar and the input as a hidden field.
	 */
	public $inline = false;


	/**
	 * Renders the widget.
	 */
	public function run()
	{
		echo $this->renderWidget() . "\n";
		if ($this->language !== false) {
			$view = $this->getView();
			DatePickerRegionalAsset::register($view);

			$options = Json::encode($this->clientOptions);
			$view->registerJs("$('#{$this->options['id']}').datepicker($.extend({}, $.datepicker.regional['{$this->language}'], $options));");

			$options = $this->clientOptions;
			$this->clientOptions = false;  // the datepicker js widget is already registered
			$this->registerWidget('datepicker', DatePickerAsset::className());
			$this->clientOptions = $options;
		} else {
			$this->registerWidget('datepicker', DatePickerAsset::className());
		}
	}

	/**
	 * Renders the DatePicker widget.
	 * @return string the rendering result.
	 */
	protected function renderWidget()
	{
		$contents = [];

		if ($this->inline === false) {
			if ($this->hasModel()) {
				$contents[] = Html::activeTextInput($this->model, $this->attribute, $this->options);
			} else {
				$contents[] = Html::textInput($this->name, $this->value, $this->options);
			}
		} else {
			if ($this->hasModel()) {
				$contents[] = Html::activeHiddenInput($this->model, $this->attribute, $this->options);
				$this->clientOptions['defaultDate'] = $this->model->{$this->attribute};
			} else {
				$contents[] = Html::hiddenInput($this->name, $this->value, $this->options);
				$this->clientOptions['defaultDate'] = $this->value;
			}
			$this->clientOptions['altField'] = '#' . $this->options['id'];
			$this->options['id'] .= '-container';
			$contents[] = Html::tag('div', null, $this->options);
		}

		return implode("\n", $contents);
	}
}
