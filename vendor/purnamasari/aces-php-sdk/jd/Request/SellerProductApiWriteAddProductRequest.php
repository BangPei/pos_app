<?php
 namespace Purnamasari\JD\Request;

class SellerProductApiWriteAddProductRequest
{
	private $apiParas = array();
	
	public function getApiMethodName(){
	  return "jingdong.seller.product.api.write.addProduct";
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
    private  $spuInfo;

    public function setSpuInfo($spuInfo){
        $this->apiParas['spuInfo'] = $spuInfo;
    }
    public function getSpuInfo(){
        return $this->apiParas['spuInfo'];
    }
    private  $skuList;

    public function setSkuList($skuList){
        $this->apiParas['skuList'] = $skuList;
    }
    public function getSkuList(){
        return $this->apiParas['skuList'];
    }
}

?>