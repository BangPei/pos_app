<?php
 namespace Purnamasari\JD\Request;

class SellerProductSkuWriteUpdateProductImagesRequest
{
	private $apiParas = array();
	
	public function getApiMethodName(){
	  return "jingdong.seller.product.sku.write.updateProductImages";
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
    private  $imageApiVo;

    public function setImageApiVo($imageApiVo){
        $this->apiParas['imageApiVo'] = $imageApiVo;
    }
    public function getImageApiVo(){
        return $this->apiParas['imageApiVo'];
    }
}

?>