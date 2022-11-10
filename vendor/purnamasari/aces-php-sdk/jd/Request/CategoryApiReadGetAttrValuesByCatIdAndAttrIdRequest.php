<?php
 namespace Purnamasari\JD\Request;

class CategoryApiReadGetAttrValuesByCatIdAndAttrIdRequest
{
	private $apiParas = array();
	
	public function getApiMethodName(){
	  return "jingdong.category.api.read.getAttrValuesByCatIdAndAttrId";
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
                                    	                   			private $catId;
    	                        
	public function setCatId($catId){
		$this->catId = $catId;
         $this->apiParas["catId"] = $catId;
	}

	public function getCatId(){
	  return $this->catId;
	}

                        	                   			private $attrId;
    	                        
	public function setAttrId($attrId){
		$this->attrId = $attrId;
         $this->apiParas["attrId"] = $attrId;
	}

	public function getAttrId(){
	  return $this->attrId;
	}

                        	                   			private $currentPage;
    	                        
	public function setCurrentPage($currentPage){
		$this->currentPage = $currentPage;
         $this->apiParas["currentPage"] = $currentPage;
	}

	public function getCurrentPage(){
	  return $this->currentPage;
	}

                        	                   			private $pageSize;
    	                        
	public function setPageSize($pageSize){
		$this->pageSize = $pageSize;
         $this->apiParas["pageSize"] = $pageSize;
	}

	public function getPageSize(){
	  return $this->pageSize;
	}

}





        
 

