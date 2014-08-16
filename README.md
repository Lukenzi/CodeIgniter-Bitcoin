CodeIgniter-Bitcoin
===================

Zjištění aktuálního kurzu Bitcoinu pro PHP framework CodeIgniter

Aktuální kurz je zjišťován ze serveru [Bitstamp.net](https://bitstamp.net) a je uveden v dolarech za 1BTC.


Požadavky
---------

* PHP 5.3.0 nebo novější
* Framevork CodeIgniter
* Funkce "json_decode"


Použití
-------

Třídu je třeba před použitím v controlleru prvně načíst:

```php
$this->load->library('kurz_btc');
```

poté můžete vrátit pole všech dat:

```php
$this->btc_kurz->GetAll();
```

nebo můžete vrátit jen jednu položku podle klíče (last, high, low, ask, bid, volume):

```php
$this->btc_kurz->Get('last');
```

případně si můžete nechat zobrazit chybu (pokud k nějaké dojde):

```php
$this->kurz_btc->GetError();
```

Příklady použití v controlleru CodeIgniteru
-------------------------------------------

```php
// načtení knihovny
$this->load->library('kurz_btc');

// zjištění aktuálního kurzu
$data['btc'] = $this->kurz_btc->Get('last');

// zjištění nejvyššího kurzu
$data['btc_max'] = $this->kurz_btc->Get('high');

// zjištění nejnižšího kurzu
$data['btc_min'] = $this->kurz_btc->Get('low');
```

Doporučení
----------

Protože API Bitstampu umožňuje pouze jeden dotaz za 1 vteřinu (jinak může zablokovat IP adresu vašeho serveru),
doporučuji vytvořit si stránku (controller) s názvem například "API", která bude zobrazovat pouze požadovaný výsledek (např. aktuální kurz).
Poté v tomto controlleru nastavte ukládání do cache na například 1 minutu pomocí funkce `$this->output->cache(1);`.
Místo načítání kurzu přímo z Bitstampu pomocí této knihovny budete pak načítat kurz z této nově vytvořené stránky.
Kurz se ve výsledku nebude zjišťovat pokaždé, ale pouze podle nastavené cache stránky, tedy v tomto příkladu jednu minutu.


Ukázka vlastního API pro zjištění kurzu BTC
-------------------------------------------

```php
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*!
 * BTC API
 */
class Api extends CI_Controller {


	public function __construct(){
		parent::__construct();
        log_message('debug', "API controller Initialized");

		// inicializace třídy Kurz_btc
        $this->load->library('kurz_btc');
	}



	// při zadání URL "/api" přesměrujeme na "/api/btc"
	public function index(){
		redirect('api/btc');
	}



	// na stránce "api/btc" zobrazíme kurz BTC
	public function btc(){
		// nastavení cache
		$this->output->cache(1);

		echo $this->kurz_btc->Get('last');
	}



}
/* End of file Api.php */
/* Location: ./application/controllers/Api.php */
```

