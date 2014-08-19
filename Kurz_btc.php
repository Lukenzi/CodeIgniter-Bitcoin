<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
* Třída pro zjištění kurzu Bitcoinu v PHP frameworku CodeIgniter
*
* @author Lukenzi <lukenzi@gmail.com>
* @package Codeigniter
* @subpackage Kurz_btc
*
*/


class Kurz_btc{



	private $btc_url    = 'https://www.bitstamp.net/api/ticker/';
	private $data       = '';
	private $error      = '';



	// -----------------------------------------------------------------



	/** Inicializace třídy - kontrola existence funkce "json_decode" a zjištění dat
	 *
	 * @return void
	 */
	public function __construct(){
		// kontrola zda existuje funkce json_decode
		if(!function_exists('json_decode')){
			$this->error = 'Funkce json_decode není povolena nebo neexistuje!';
		}else{
			$this->data = $this->_GetData();
		}
	}



	/** Zjištění kurzu podle klíče
	 *
	 * @param string Klíč
	 * @return string Kurz
	 */
	public function Get($key){
		if(empty($this->error)){
			$result = $this->data[$key];
			return round($result, 3);
		}else{
			return '';
		}
	}



	/** Vrátí všechna data z Bitstampu
	 *
	 * @return array Data z Bitstampu
	 */
	public function GetAll(){
		if(empty($this->error)){
			return $this->data;
		}else{
			return '';
		}
	}



	/** Zobrazení případné chyby
	 *
	 * @return string Případná chyba
	 */
	public function GetError(){
		if(!empty($this->error)){
			return $this->error;
		}else{
			return '';
		}
	}



	/** Získání dat z Bistampu
	 *
	 * @return array|false Vrátí pole dat nebo false při neúspěchu
	 */
	private function _GetData(){
		$json = @file_get_contents($this->btc_url);
		if($json !== FALSE){
			$data = @json_decode($json, TRUE);
			if($data !== FALSE){
				return $data;
			}
		}
		$this->error = 'Nepodařilo se načíst kurz!';
		return false;
	}



}
/* End of file Kurz_btc.php */
/* Location: ./application/libraries/Kurz_btc.php */
