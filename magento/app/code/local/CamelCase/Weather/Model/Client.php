<?php
class CamelCase_Weather_Model_Client
{

    const API_URL = 'http://api.openweathermap.org/data/2.5/weather?q=%s';

    const KELVIN_CELSIUS_CONVERSION = 273.15;

    private $city;

    private $data;

    public function __construct()
    {
        $this->city = Mage::helper('camelcase_weather/data')->getConfigCity();
    }

    private function retrieveWeather()
    {
        $url = sprintf(self::API_URL, $this->city);
        $raw = file_get_contents($url);
        $this->data = json_decode($raw);
    }

    public function getData($key=null)
    {
        if (!$this->data) {
            $this->retrieveWeather();
        }

        if ($key) {
            if (property_exists($this->data, $key)) {
                return $this->data->{$key};
            } else {
                return null;
            }
        }

        return $this->data;
    }

    public function setCity($city)
    {
        $this->city = $city;
        $this->data = null;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getTemp()
    {
        $main = $this->getData('main');

        $tempKelvin = $main->temp;
        if (!$tempKelvin) {
            return null;
        }

        $tempCelsius = $tempKelvin - self::KELVIN_CELSIUS_CONVERSION;
        $tempFormatted = sprintf('%d°C', $tempCelsius);

        return $tempFormatted;
    }

    public function getConditions()
    {
        $weather = $this->getData('weather');
        
        $conditions = $weather[0]->main;

        return $conditions;
    }

}