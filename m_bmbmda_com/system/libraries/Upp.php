<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Upp {
    public $BasePath;
        public $Width;
        public $Height;
        public $eName;
        public $Value;
        public $AutoSave;
function SinaEditor($eName){
                $this->eName=$eName;
                $this->BasePath='.';
                $this->AutoSave=false;
                $this->Height=460;
                $this->Width=630;
                return $this;
        }
function create(){
                $ur=base_url();
                $ReadCookie=$this->AutoSave?1:0;
                return <<<eot
                <textarea name="{$this->eName}" id="{$this->eName}" style="display:none;">{$this->Value}</textarea>
                <iframe src="{$ur}/editweb/Edit/editor.htm?id={$this->eName}&ReadCookie={$ReadCookie}" frameBorder="0" marginHeight="0" marginWidth="0" scrolling="No" width="{$this->Width}" height="{$this->Height}"></iframe>
eot;
        }

}