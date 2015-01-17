<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * PHP class «Assert»
 *
 * Copyright © 2014, 2015 Nelson Martell (http://fb.me/nelson6e65)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright	Copyright © 2014, 2015 Nelson Martell
 * @link		https://github.com/nelson6e65/NelsonMartell
 * @package  	NelsonMartell.Utilities
 * @license  	http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

namespace NelsonMartell\Utilities {
	use NelsonMartell\Object;
	use NelsonMartell\Version;
	use \InvalidArgumentException;

	//spl_autoload_register();

	$_class = "Asset";
	$_constant = implode('_', explode('\\', __NAMESPACE__)) . '_' . $_class;

	if (!defined($_constant)):
		define($_constant, true);


	include('/../Object.php');
	include('/../Version.php');

	/* *
	 * Representa un recurso estático de una página, como elementos js y css, que poseen varias
	 * versiones y están organizadas en subdirectorios, proponiendo una estructura predeterminada.
	 * Contiene métodos y propiedades para obtener las rutas de los directorios y recursos de las
	 * diferentes versiones del framework.
	 *
	 *
	 * @package  NelsonMartell.Utilities
	 * @author   Nelson Martell (@yahoo.es: nelson6e65-dev)
	 * */
	class Asset extends Object {
		/* *
		 * Crea una nueva instancia de la clase Asset
		 *
		 *
		 *
		 * */
		public function __construct($name = null, $versions = null, $cdnUri = null) {
			parent::__construct();
			unset($this->Name, $this->Versions, $this->ShortName, $this->CdnUri, $this->RootDirectory);

			if ($name == null) {
				$this->_name = '';
				$this->_shortName = '';
			} else {
				$this->Name = $name;
			}

			if ($this->Name == '' && $versions != null) {
				throw new InvalidArgumentException(_('Can not specify $versions argument if $name argument is null.'));
			}

			if ($versions == null) {
				$versions = array();
			}




			if (is_array($versions)) {

				$this->_versions = array();

				if (count($versions) > 0) {
					$i = 0;
					foreach($versions as $version) {
						$v = $version;
						if (!($v instanceof Version)) {
							try {
								$v = Version::Parse($version);
							} catch (InvalidArgumentException $e) {
								throw new InvalidArgumentException('$versions argument must be an array of Version objects or any objects parseable into Version.', 0, $e);
							}
						}

						$this->_versions[$i] = $v;

						$i += 1;
					}
				}

			} else {
				// Trata de convertir $versions en un objeto Versión
				try {
					$v = Version::Parse($versions);
				} catch (InvalidArgumentException $e) {
					throw new InvalidArgumentException('$versions argument must be an array of Version objects (or empty), a Version object or any object parseable into Version.', 0, $e);
				}

				$this->_versions = array($v);
			}

			$this->CdnUri = $cdnUri;
		}


		/* *
		 * Obtiene o establece el nombre original del recurso.
		 * A partir de éste se determinará la ruta y el nombre real del archivo (que, por defecto,
		 * será éste mismo pero convertido en minúsculas y reemplazando sus espacios en blanco por
		 * guiones (' ' -> '-')).
		 *
		 * @see  $ShortName
		 * @var  string Nombre del recurso
		 * */
		public $Name;
		private $_name;

		public function get_Name() {
			return $this->_name;
		}

		public function set_Name($value) {
			if (!is_string($value)) {
				throw new InvalidArgumentException('$value argument must be string.');
			}

			if (str_word_count($value) == 0) {
				throw new InvalidArgumentException('$value argument can not be an empty or whitespace string.');
			}

			$this->_name = trim($value);

			$this->_shortName = str_replace(' ', '-', strtolower($this->_name));
		}

		/*
		 * Obtiene el nombre real del recurso, que representa al nombre real de .
		 *
		 * @var  string Nombre del recurso en su forma generada
		 * */
		public $ShortName;
		private $_shortName;

		public function get_ShortName() {
			return $this->_shortName;
		}

		/*
		 * Obtiene la lista de versiones
		 *
		 * @var  List Lista de versiones del recurso
		 * */
		public $Versions;
		private $_versions;

		public function get_Versions() {
			return $this->_versions;
		}
		/*
		public function set_Versions($value) {
			$this->_versions = $value;
		}
		*/


		/* *
		 * Obtiene o establece el CDN del recurso.
		 * Debe modificarse la URL, colocando '{v}' en vez de la versión.
		 * @example  Un CDN para el JavaScript de jQuery UI v1.11.2 es:
		 *   "//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"
		 *   Entonces el valor de esta propiedad debe ser:
		 *   "//ajax.googleapis.com/ajax/libs/jqueryui/{v}/jquery-ui"
		 *
		 *
		 *
		 * @var  string CDN
		 * */
		public $CdnUri;
		private $_cdnUri;

		public function get_CdnUri() {
			return $this->_cdnUri;
		}

		public function set_CdnUri($value) {
			$this->_cdnUri = (string) $value;
		}

		/*
			public static function getJavascriptPath($api) {

			}

			public static function getCssPath($api) {

			}

			public static function getImgPath($api){

			}

			public static function getResourcesPath($api){

		}*/



		/* *
		 * Obtiene el directorio principal del recurso.
		 *
		 *
		 * @var  string Ruta inicial del recurso
		 * */
		public $RootDirectory;
		public function get_RootDirectory() {
			return $this->ShortName . '/';
		}

		/* *
		 * Obtiene la ruta del directorio de la versión especificada. Si no se especifica,
		 * se devuelve la versión más reciente.
		 *
		 *
		 * @return  string Ruta del directorio de la versión especificada.
		 * */
		public function GetDirectoryPath($version = null) {
			$p = $this->RootDirectory;

			if ($version == null) {
				sort($this->_versions); // TODO: Check performance

				$c = count($this->Versions);

				if ($c > 0) {
					$version = $this->Versions[$c - 1];
				}
			}

			try {
				$version = Version::Parse($version);
			} catch (InvalidArgumentException $e) {
				throw new InvalidArgumentException('$version argument must be an Version object or any object parseable into Version.', 0, $e);
			}

			return sprintf('%s%s/', $this->RootDirectory, $version);

		}


		/* *
		 * Obtiene la ruta del recurso de la versión especificada. Si no se especifica, se devuelve la
		 * versión más reciente.
		 *
		 * @return  string Ruta del recurso
		 * */
		public function GetResourcePath($version = null, $append = '') {

			$r = sprintf('%s%s%s', $this->GetDirectoryPath($version), $this->ShortName, $append);

			return $r;
		}
	}

	endif;
}