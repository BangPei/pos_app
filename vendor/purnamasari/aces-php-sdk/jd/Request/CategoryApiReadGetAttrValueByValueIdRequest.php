<?php
 namespace Purnamasari\JD\Request;

class CategoryApiReadGetAttrValueByValueIdRequest
{
	private $apiParas = array();
	
	public function getApiMethodName(){
	  return "jingdong.category.api.read.getAttrValueByValueId";
	}
	
	public function getApiParas(){
	    if(empty($this->apiParas)){
            return "{}";
        }
        return json_encode($this->apiParas);
	}
	
	public function check(){
		
	}
	
	public function putOtherTextParam($key, $value){
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}

    private  $version;

    public function setVersion($version){
        $this->version = $version;
    }

    public function getVersion(){
        return $this->version;
    }
                                    	                   			private $valueId;
    	                        
	public function setValueId($valueId){
		$this->valueId = $valueId;
         $this->apiParas["valueId"] = $valueId;
	}

	public function getValueId(){
	  return $this->valueId;
	}

}





        
 

