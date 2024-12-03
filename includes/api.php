<?php
class WC_API_Handler
{
    public static function update_product_stock()
    {
        global $g_products;
        $c_key = 'ck_940ef39fc8eedf1f6f46f604ff63cc247f789157';
        $c_secret = 'cs_ea4a0871025bdb962007e6fc1eb4de5572d57578';

        $apiurl = site_url() . '/wp-json/wc/v3/products';
        foreach ($g_products as $product) {
            $sku = $product['sku'];
            $stock = $product['stock'];

            $resp = wp_remote_get("$apiurl?sku=$sku", [
                'headers' => [
                    'Authorization' => 'Basic ' . base64_encode("$c_key:$c_secret"),
                ],
            ]);

            if (is_wp_error($resp)) {
                error_log('Error Get' . $resp->get_error_message());
            } else {
                $s_c = wp_remote_retrieve_response_code($resp);
                error_log('Error Code: ' . $s_c);
                $body = wp_remote_retrieve_body($resp);
                error_log('Body: ' . print_r($body, true));

                if ($s_c == 200) {
                    $pData = json_decode($body, true);
                    if (!empty($pData)) {
                        $pID = $pData[0]['id'];

                        $resp = wp_remote_post("$apiurl/$pID", [
                            'method' => 'PUT',
                            'body' => json_encode(['stock_quantity' => $stock]),
                            'headers' => [
                                'Content-Type' => 'application/json',
                                'Authorization' => 'Basic ' . base64_encode("$c_key:$c_secret"),
                            ],
                        ]);

                        if (is_wp_error($resp)) {
                            error_log('Error PUT' . $resp->get_error_message());
                            return;
                        }
                    }
                } else {
                    error_log('Not Product Fount ID -' . $sku);
                }
            }
        }
    }
}

add_action('update_product_stock_event', ['WC_API_Handler', 'update_product_stock']);