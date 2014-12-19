<?php
# #####################################################
# Clase Property para PHP 
# Versión: 1.0.0.0 (2013-04-19) 
# ----------------------------------------------
# Autor: 
# 	Nelson Martell (nelson6e65) 
#  	E-Mail: nelson6e65-dev@yahoo.es 
# 	Facebook: http://fb.me/nelson6e65 
#   
#  Copyright © 2013 Nelson Martell 
#
# #####################################################

#ifndef C_Property
	#define C_Property
	#ifndef C_Type
		#include "Type.php"
	#endif	
	//Clase
#endif
if (!defined("C_Property")) {
	define("C_Property", true);
	
	include('Type.php');
	include('Exceptions/ALL.inc');
	
	
	///	<sumary>
	///		Define una contenedor que permite manejar atributos fuertemente tipados
	///	</sumary>
	///	<remarks>
	///		Los objetos deben definir los métodos 'get_' y 'set_' basándose 
	///		en los métodos correspondientes definidos en esta clase.
	///	</remarks>
	class Property {
		/// Indica si la propiedad es de sólo lectura
		private $ReadOnly = false;
		
		//Obtiene un valor que indica si esta propiedad se definió de sólo lectura
		public function IsReadOnly() {
			return $this->ReadOnly;
		}
		
		private $Value = null;	
		
		/// Obtiene o establece el valor
		public function Value($value = null) {
			if ($value == null) {
				return $this->Get();
			} else {
				return $this->Set($value);
			}
		}
		
		public function Set($value) {		
			if ($this->IsReadOnly()) {
				$msg1 = "No se puede asignar la variable; la propiedad es de sólo lectura";
				if (defined("DEBUG")){
					echo "<b>DEBUG:</b>";
					throw new InvalidOperationException($msg1);
				}
				else { die($msg1); }
			}
			
			
			
					

			$tipoActual = Type::typeof($this->Value); //gettype($this->Value);
			
			//if ($tipoActual->IsValueType())
			if ($value == null) {//No puede asignársele null
				throw new InvalidOperationException(
					"No se puede establecer el valor de la propiedad.", 
					new ArgumentNullException('$value', 'Utilizar el método Reset().')
					);
			}
			
			$tipoNuevo = Type::typeof($value); //gettype($value);
			
			
			if ($tipoActual == $tipoNuevo || $this->Value == null)
				$this->Value = $value;
			else {
				
				$msg = "\n<h3>Error:</h3>";
				$msg .= "\n<p>\n<span style=\"color:darkred; font-weight:bold;\">TypeException: </span>¡No se puede asignar el nuevo valor de la propiedad debido a que son de tipos diferentes! A saber: <br>";
				

				$color = 'Blue';
				if ($tipoActual->IsCustom()) {
					$color = 'DodgerBlue';
				}
				
				$msg .= "\n\tActual = ";
				$msg .= "(<span style=\"color:$color\">" . $tipoActual->GetName() . "</span>)";	
				
				$msg .= " <span style=\"color:OrangeRed;\">«<i>$this->Value</i>»</span><br>";
				
								
				$color = 'Blue';
				if ($tipoNuevo->IsCustom()) {
					$color = 'DodgerBlue';
				}
				
				$msg .= "\n\tNuevo = ";	
				$msg .= "(<span style=\"color:$color\">" . $tipoNuevo->GetName() . "</span>)";	
				$msg .= " <span style=\"color:OrangeRed;\">«<i>$value</i>»</span>";
				
				$msg .= "\n</p>";					
				//echo $msg; //die()
				
				$msgError = "No se puede asignar el valor: No existe conversión implícita entre '" . $tipoActual . "' y '" . $tipoNuevo . "'.";
				
				
				if (defined("DEBUG")){
					echo "<pre>";
					throw new InvalidTypeException($msgError, $value, $tipoActual);
					echo "</pre>";
				}
				else { die($msg); }
			}
		}
		
		public function Reset() {
			return $this->Value = null;
		}
		
		public function Get() {
			return $this->Value;
		}
		
		
		
		
		
		function Property($value, $readonly = false) {
			if ($value == null)
				throw new ArgumentNullException('$value');
			$this->ReadOnly = $readonly;
			$this->Value = $value;
		}
		
		function __tostring() {
			return "$this->Value";
		}
	}
}
?>