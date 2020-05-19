<?php

  namespace passwordMeter;
  // specify weights
  $weights = (object)[
    SMALL_LETTER => 26,
    CAPITAL_LETTER => 26,
    NUMERIC=> 10,
    SPECIAL_CHAR=> 33
    ];
       // specify default messages
    $messages = (object)[
        VERY_WEAK => "Very Weak",
        WEAK => "Weak",
        GOOD => "Good",
        STRONG => "Strong",
        VERY_STRONG => "Very Strong"
    ];

    // sepecify default configs
    $configs =(object)[ 
        SMALL_LETTER  => [
            min => 0,
            max => 26
        ],
        CAPITAL_LETTER  => [
            min => 0,
            max => 26
        ],
        NUMERIC => [
            min => 0,
            max => 255
        ],
        SPECIAL_CHAR => [
            min => 0,
            max => 33
        ] 
    ];


  class passwordMeter {

        public function get_weights() {
            return $weights; // get weight 
        }
        // config: function(config = {}) {
        //     // override config if you need
        //     configs = Object.assign(configs, config);
        //     return this;
        // },
        public function get_configs() {
            return $configs; // get configs
        }
        // message: function(message = {}) {
        //     // override messages if you need
        //     messages = Object.assign(messages, message);
        //     return this;
        // },
        public function get_messages() {
            return $messages; // get messages
        }
    
        public function check_size($size_obj, $size) {
            // check validation size
            return $size_obj->min <= $size && $size_obj->max >= $size; 
        }
       
        public function password_strength($pass) {
            $len = strlen($pass);
            $weight = 0;
            // $this->getRandomQuotes();
            try {
                    // collect weight of password
                    $weight = $this->get_weight($pass);
            } catch (Exception $e) {
                // throw error
                // err(error);
                return $e->getMessage();
            }
                 // collect strength of password
            $ln2Val = log(2)/log(2.71828); //log to lon transfer fro base log2
            $lnXVal = log(pow($weight, $len))/log(2.71828);
            $strength = ceil($lnXVal/$ln2Val);
            
            if ($strength < 28) {
                // "very weak" callback with message and value
                
                $arr = array('message'=>$messages->VERY_WEAK, 'strength'=>$strength);
                return $arr;
                // cb($messages->VERY_WEAK, $strength);
            }
            else if($strength < 36) {
                // "weak" callback with message and value
                $arr = array('message'=>$messages->WEAK, 'strength'=>$strength);
                return $arr;
                // cb($messages->WEAK, $strength);
            }
            else if($strength < 60) {
                // "good" callback with message and value
                $arr = array('message'=>$messages->GOOD, 'strength'=>$strength);
                return $arr;
                // cb($messages->GOOD, $strength);
            }
            else if($strength < 128) {
                // "strong" callback with message and value
                $arr = array('message'=>$messages->STRONG, 'strength'=>$strength);
                return $arr;
                // cb($messages->STRONG, $strength);
            }
            else {
                // "very strong" callback with message and value
                $arr = array('message'=>$messages->VERY_STRONG, 'strength'=>$strength);
                return $arr;
                // cb($messages->VERY_STRONG, $strength);
            }
            

        }
        function get_weight($pass){
            $weight = 0;
            $capital_letter = strlen(preg_match_all('/[^A-Z]/', '', $pass));
            $small_letter = strlen(preg_match_all('/[^a-z]/', '', $pass));
            $numeric = strlen(preg_match_all('/[^0-9]/', '', $pass));
            $speicial_char = strlen(preg_match_all('/[!@#$%^&*()]/', '', $pass));
            $valid_size = false;

            // checking if capital letter here & validation size proper or not
            if ($capital_letter && ($valid_size = $this->check_size($configs->CAPITAL_LETTER, $capital_letter))) {
                $weight += $weights->CAPITAL_LETTER;
            } else {
                // throw message
                if (!$valid_size) throw `Capital letter must be min: {$configs->CAPITAL_LETTER->min} and max: {$configs->CAPITAL_LETTER->max}`;
            }

            // checking if small letter here & validation size proper or not
            if ($small_letter && ($valid_size = $this->check_size($configs->SMALL_LETTER, $small_letter))) {
                $weight += $weights->SMALL_LETTER;
            } else {
                // throw message
                if (!$valid_size) throw `SMALL letter must be min: {$configs->SMALL_LETTER->min} and max: {$configs->SMALL_LETTER->max}`;
            }

            // checking if numeric value here & validation size proper or not
            if ($numeric && ($valid_size = $this->check_size($configs->NUMERIC, $numeric))) {
                $weight += $weights->NUMERIC;
            } else {
                // throw message
                if (!$valid_size) throw new Exception(`NUMERIC value must be min: {$configs->NUMERIC->min} and max: {$configs->NUMERIC->max}`);
            }

             // checking if special letter here & validation size proper or not
             if ($speicial_char && ($valid_size = $this->check_size($configs->SPECIAL_CHAR, $speicial_char))) {
                $weight += $weights->SPECIAL_CHAR;
            } else {
                // throw message
                if (!$valid_size) throw `SMALL letter must be min: {$configs->SPECIAL_CHAR->min} and max: {$configs->SPECIAL_CHAR->max}`;
            }

            return $weight; // returing weight after calculate

        }
    }
    
