<?php
class TestWidget extends CWidget
{
    public function run()
    {
        $random = rand(1,3);
        if ($random == 1)
        {
            $ad = "ad1.jpg";
        }
        else if ($random == 2)
        {
            $ad = "ad2.jpg";
        }
        else 
        {
            $ad = "ad3.png";
        }
        
        $this->render('test',array(
            'ad' => $ad,
        )        
        );  
    }
}