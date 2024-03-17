<?php

namespace Webshop;

abstract class Product {
    protected $title;
    protected $price;
    
    public function __construct($title, $price) {
        $this->title = $title;
        $this->price = $price;
    }
    
    public function getTitle() {
        return $this->title;
    }
    
    public function getPrice() {
        return $this->price;
    }
    
    abstract public function displayInfo();
}

class Music extends Product {
    private $artist;
    
    public function __construct($title, $price, $artist) {
        parent::__construct($title, $price);
        $this->artist = $artist;
    }
    
    public function getArtist() {
        return $this->artist;
    }
    
    public function displayInfo() {
        echo "<tr>
                <td>{$this->getTitle()}</td>
                <td>Muziek</td>
                <td>{$this->getPrice()}</td>
                <td>{$this->getArtist()}</td>
              </tr>";
    }
}

class Game  extends Product {
    private $game;
    
    public function __construct($title, $price, $game) {
        parent::__construct($title, $price);
        $this->game = $game;
    }
    
    public function GetGame() {
        return $this->game;
    }
    
    public function displayInfo() {
        echo "<tr>
                <td>{$this->getTitle()}</td>
                <td>Muziek</td>
                <td>{$this->getPrice()}</td>
                <td>{$this->getGame()}</td>
              </tr>";
    }
}

class DVD extends Product {
    private $director;
    
    public function __construct($title, $price, $director) {
        parent::__construct($title, $price);
        $this->director = $director;
    }
    
    public function getDirector() {
        return $this->director;
    }
    
    public function displayInfo() {
        echo "<tr>
                <td>{$this->getTitle()}</td>
                <td>Film</td>
                <td>{$this->getPrice()}</td>
                <td>{$this->getDirector()}</td>
              </tr>";
    }
}

// Maak een array van producten
$products = array(
    new Music("Album Title", 15.99, "Artist Name"),
    new DVD("Movie Title", 19.99, "Director Name"),
    new Game("Game naam", 15.99, "Game naam"),
    new DVD("Movie Title", 19.99, "Director Name")
);

// Toon de tabel met productinformatie
echo "<table border='1'>
        <tr>
          <th>Product Naam</th>
          <th>Categorie</th>
          <th>Verkoopprijs</th>
          <th>Informatie</th>
        </tr>";
foreach ($products as $product) {
    $product->displayInfo();
}
echo "</table>";

?>