<? 
// элемент ymaps написан worstinme@ya.ru 

 
class ElementYandex_Maps extends Element implements iSubmittable {
	public function __construct() {
			// call parent constructor
			parent::__construct();
			// set callbacks
			$this->registerCallback('showballoncontent');
	}
	public function getSearchData() {
		$value = $this->get('location');
		if ($value) {
			$data = json_decode($value);
			if ($data and $data->lan and $data->lat) {
				return $data->lat.','.$data->lan;
			}
		}
		return null;
	}
	public function hasValue($params = array()) { 
			$value = $this->get('location');
			return !empty($value);
	}
	
	public function render($params = array()) {
		
		$params			   = $this->app->data->create($params);
		$map_type          = $params->get('map_type');
		
		if ($layout = $this->getLayout()) {
			return $this->renderLayout($layout, array('params' => $params));
		}
		return null;
	}
	
	public function edit() {
		if ($layout = $this->getLayout('edit.php')) {
			return $this->renderLayout($layout);
		}
		return null;
	}
	
	public function renderSubmission($params = array()) {
        return $this->edit();
	}
	 public function geocode() {
		 return true;
	 }

	public function validateSubmission($value, $params) {
        $validator = $this->app->validator->create('', array('required' => $params->get('required')), array('required' => 'Please enter a location'));
        $clean = $validator->clean($value->get('location'));
        $icon = $validator->clean($value->get('icon'));
		return array('location' => $clean, 'icon' => $icon);
	}
	
	public function _getLoc(){
	 	return $this->get('location');
	}
	
	public function showballoncontent ($start = null) {
		$path   = 'item';
		$prefix = 'item.';
		$marker_text = '';
		$renderer = $this->app->renderer->create('item')->addPath(array($this->app->path->path('component.site:'), $this->_item->getApplication()->getTemplate()->getPath()));
		$layout = 'balloon';
		if ($item = $this->getItem()) {
			$type   = $item->getType()->id;
			if ($renderer->pathExists($path.DIRECTORY_SEPARATOR.$type)) {
				$path   .= DIRECTORY_SEPARATOR.$type;
				$prefix .= $type.'.';
			}
			if (in_array($layout, $renderer->getLayouts($path)) && !$render_all && $item->getState()) {
				$marker_text = str_replace($jertva,$gumno,$renderer->render($prefix.$layout, array('item' => $item)));
			}
		}
		return json_encode(array(
			'message' => $marker_text
		));
	}
}

?>