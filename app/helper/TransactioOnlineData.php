<?

use App\Models\OnlineShop;

class TransactionOnline
{
    public $create_time_online;
    public $update_time_online;
    public $message_to_seller;
    public $order_no;
    public $order_status;
    public $tracking_number;
    public $delivery_by;
    public $pickup_by;
    public $total_amount;
    public $total_qty;
    public $status;
    public $online_shop_id;
    public $order_id;
    public $shipping_provider_type;
    public $product_picture;
    public $package_picture;
    public $items;

    public function getOnlineShopID($name)
    {
        $platform = OnlineShop::where('name', 'JD.ID')->first();
        return $platform->id;
    }
}
