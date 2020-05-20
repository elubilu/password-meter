<?php

  namespace passwordMeter;
  
    $GLOBALS = array(
        'weights'=>[
            'SMALL_LETTER' => 26,
            'CAPITAL_LETTER' => 26,
            'NUMERIC'=> 10,
            'SPECIAL_CHAR'=> 33
        ],
        'messages'=>[
            'VERY_WEAK' => "Very Weak",
            'WEAK' => "Weak",
            'GOOD' => "Good",
            'STRONG' => "Strong",
            'VERY_STRONG' => "Very Strong"
        ],
        'configs'=>[
            'SMALL_LETTER' => [

            'min' => 0,
            'max' => 26 
            ],
            'CAPITAL_LETTER' => [

                'min' => 0,
                'max' => 26 
            ],
            'NUMERIC' => [

                'min' => 0,
                'max' => 255 
            ],
            'SPECIAL_CHAR' => [

                'min' => 0,
                'max' => 33 
            ],
        ]


    );


  class passwordMeter {
    
        protected $glob;
        public function __construct() {
            global $GLOBALS;
            $this->glob =& $GLOBALS;
        }
       
       
        public function get_weights() {
            // global $weights;
            return $this->glob['weights']; // get weight 
        }
       
        public function get_configs() {
            return $this->glob['configs']; // get configs
        }
       
        public function get_messages() {
            return $this->glob['messages']; // get messages
        }
    
        public function check_size($size_obj, $size) {
            // check validation size
            return $size_obj['min'] <= $size && $size_obj['max'] >= $size; 
        }
       
        public function password_strength($pass) {
            // global $weights, $configs, $messages;

            $len = strlen($pass);
            if(!$len){
                $arr = array('message'=>$messages['VERY_WEAK'], 'strength'=>"Password is required");
                return $arr;
            }
            // return $len;s
            $weight = 0;
            // $this->getRandomQuotes();
            try {
                    // collect weight of password
                    $weight = $this->get_weight($pass);
                    // return $weight;
            } catch (Exception $e) {
                // throw error
                // err(error);
                return $e->getMessage();
            }
                 // collect strength of password
            $ln2Val = log(2)/log(2.71828); //log to lon transfer fro base log2
            $lnXVal = log(pow($weight, $len))/log(2.71828);
            $strength = ceil($lnXVal/$ln2Val);
            $percnt = ceil($strength*100/128);
            $percnt = min(100,$percnt);
            $percnt = $percnt.'%';
            $messages = $this->glob['messages'];
            
            if ($strength < 28) {
                // "very weak" callback with message and value
                
                $arr = array('message'=>$messages['VERY_WEAK'], 'strength'=>$strength, 'percentage'=>$percnt);
                return $arr;
                // cb($messages->VERY_WEAK, $strength);
            }
            else if($strength < 36) {
                // "weak" callback with message and value
                $arr = array('message'=>$messages['WEAK'], 'strength'=>$strength, 'percentage'=>$percnt);
                return $arr;
                // cb($messages->WEAK, $strength);
            }
            else if($strength < 60) {
                // "good" callback with message and value
                $arr = array('message'=>$messages['GOOD'], 'strength'=>$strength, 'percentage'=>$percnt);
                return $arr;
                // cb($messages->GOOD, $strength);
            }
            else if($strength < 128) {
                // "strong" callback with message and value
                $arr = array('message'=>$messages['STRONG'], 'strength'=>$strength, 'percentage'=>$percnt);
                return $arr;
                // cb($messages->STRONG, $strength);
            }
            else {
                // "very strong" callback with message and value
                $arr = array('message'=>$messages['VERY_STRONG'], 'strength'=>$strength, 'percentage'=>$percnt);
                return $arr;
                // cb($messages->VERY_STRONG, $strength);
            }
            

        }
        function get_weight($pass){
            // global $weights, $configs, $messages;
            $weight = 0;
            $capital_letter = preg_match_all('/[A-Z]/',  $pass);
            $small_letter = preg_match_all('/[a-z]/',  $pass);
            $numeric = preg_match_all('/[0-9]/', $pass);
            $speicial_char = preg_match_all('/[!@#$%^&*()]/', $pass);

            // return $small_letter;
            $valid_size = false;
            $weights = $this->glob['weights'];
            $configs = $this->glob['configs'];
            $messages = $this->glob['messages'];
            // checking if capital letter here & validation size proper or not
            if ($capital_letter && ($valid_size = $this->check_size($configs['CAPITAL_LETTER'], $capital_letter))) {
                $weight += $weights['CAPITAL_LETTER'];
            } 
            
            // checking if small letter here & validation size proper or not
           
            if ($small_letter) {
                $weight +=  $weights['SMALL_LETTER'];
                // return Gweights;
            } 
            

            // checking if numeric value here & validation size proper or not
            if ($numeric && ($valid_size = $this->check_size($configs ['NUMERIC'], $numeric))) {
                $weight += $weights['NUMERIC'];
            } 

             // checking if special letter here & validation size proper or not
             if ($speicial_char && ($valid_size = $this->check_size($configs['SPECIAL_CHAR'], $speicial_char))) {
                $weight += $weights['SPECIAL_CHAR'];
            } 

            return $weight; // returing weight after calculate

        }
    }
    

