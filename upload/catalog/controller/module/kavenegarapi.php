<?php
class ControllerModuleKavenegarApi extends Controller
{

	public function find_order_id($array, $keySearch="order_id"){
		try {
			if(is_array($array)){
				foreach ($array as $key => $item) {
					if ($key == $keySearch) {
						if(is_array($item)){
							return $array[$key][$keySearch];
						}
						else{
							return $item;
						}
					}
					else {
						if (is_array($item)) {
						   return findKey($item, $keySearch);
						}
					}
				}	
				return "";	
			}else{
				return "";
			}
		}catch (Exception $ex) {
			return "";
        }
	}

    public function onCheckout($order_id)
    {       
		$this->log->write('KavenegarApi onCheckout : func_get_arg =...'.print_r(func_get_args(),true));
        $this->load->model('checkout/order');
        $this->load->model('setting/setting');
        $this->load->model('module/kavenegarapi');
		
        if (version_compare(VERSION, '2.2.0.0', ">=")) {
            if (isset($this->session->data['order_id'])) {
                $order_id = $this->session->data['order_id'];
            } else {
                $order_id = 0;
            }
        } 
        if ($order_id == 0 || is_array($order_id)) {
			$order_id=$this->find_order_id($order_id);
		    if ($order_id == 0 || is_array($order_id)) {
				$this->log->write('KavenegarApi order_id is Null');
				return;
			}
        }
        $order_info = $this->model_checkout_order->getOrder($order_id);
		
        $kavenegarapi_setting = $this->model_setting_setting->getSetting('KavenegarApi', $order_info['store_id']);
        if (version_compare(VERSION, '2.1.0.0', ">=") && version_compare(VERSION, '2.1.0.2', "<=")) {
            $this->load_library('kavenegarapi');
        } else {
            $this->load->library('kavenegarapi');
        }
        
        //Send SMS to the customer
        if (isset($kavenegarapi_setting) 
		&& isset($kavenegarapi_setting['KavenegarApi']) 
		&& ($kavenegarapi_setting['KavenegarApi']['Enabled'] == 'yes') 
		&& (!empty($kavenegarapi_setting['KavenegarApi']['APIKey'])) 
		&& ($kavenegarapi_setting['KavenegarApi']['CustomerPlaceOrder']['Enabled'] == 'yes')) {
            $this->log->write('Send SMS to the customer');
            if (!empty($order_info['telephone'])) {
                $phone = $order_info['telephone'];
            } else {
                $phone = $order_info['fax'];
            }
            $language = $this->config->get('config_language_id');
            $original = array(
                "{OrderID}",
                "{SiteName}",
                "{CartTotal}"
            );
            $replace  = array(
                $order_id,
                $this->config->get('config_name'),
                $order_info['total']
            );
            $message  = str_replace($original, $replace, $kavenegarapi_setting['KavenegarApi']['CustomerPlaceOrderText'][$language]);
			$localid="1000".(string)$order_id;
            $this->log->write($message);
            try {
                KavenegarApi::Send($kavenegarapi_setting['KavenegarApi']['APIKey'], $this->model_module_kavenegarapi->formatNumber($phone), $kavenegarapi_setting['KavenegarApi']['Sender'],$message,$localid);
            }
            catch (ApiException $ex) {
                $this->model_module_kavenegarapi->logger($ex->errorMessage());
            }
            catch (HttpException $ex) {
                $this->model_module_kavenegarapi->logger($ex->errorMessage());
            }
        }
        //Send SMS to the admin
        if (isset($kavenegarapi_setting) 
		&& isset($kavenegarapi_setting['KavenegarApi']) 
		&& ($kavenegarapi_setting['KavenegarApi']['Enabled'] == 'yes') 
		&& (!empty($kavenegarapi_setting['KavenegarApi']['APIKey'])) 
		&& ($kavenegarapi_setting['KavenegarApi']['AdminPlaceOrder']['Enabled'] == 'yes')) {
            $_OrderProductNames = "";
            $this->load->model('account/order');
            $order_products = $this->model_account_order->getOrderProducts($order_id);
            foreach ($order_products as $order_product) {
                $_OrderProductNames = $_OrderProductNames . $order_product["name"] . "\n";
            }
            
            $language     = $this->config->get('config_language_id');
            $original     = array(
                "{OrderID}",
                "{SiteName}",
                "{CartTotal}",
                "{Telephone}",
                "{ShippingAddress}",
                "{NameProducts}"
            );
            $replace      = array(
                $order_id,
                $this->config->get('config_name'),
                $order_info['total'],
                $order_info['telephone'],
                $order_info['shipping_address_1'],
                $_OrderProductNames
            );
            $message      = str_replace($original, $replace, $kavenegarapi_setting['KavenegarApi']['AdminPlaceOrderText']);
            $adminNumbers = array_map('trim', explode(',', $kavenegarapi_setting['KavenegarApi']['StoreOwnerPhoneNumber']));
			$lid=0;
            foreach ($adminNumbers as $phone) {
                try {
				  	$localid="200".$lid.(string)$order_id;
					$lid=$lid+1;
                    KavenegarApi::Send($kavenegarapi_setting['KavenegarApi']['APIKey'], $this->model_module_kavenegarapi->formatNumber($phone), $kavenegarapi_setting['KavenegarApi']['Sender'], $message,$localid);
                }
                catch (ApiException $ex) {
                    $this->model_module_kavenegarapi->logger($ex->errorMessage());
                }
                catch (HttpException $ex) {
                    $this->model_module_kavenegarapi->logger($ex->errorMessage());
                }
            }
        }
    }
	
	public function onHistoryChange($order_id)
    {
	
$this->log->write('KavenegarApi : onHistoryChange...');
$this->log->write('KavenegarApi : $order_id =...'.$order_id);
		
	    $this->load->model('checkout/order');
	    $this->load->model('setting/setting');
		if (version_compare(VERSION, '2.1.0.0', ">=") && version_compare(VERSION, '2.1.0.2', "<=")) {
            $this->load_library('kavenegarapi');
        } else {
            $this->load->library('kavenegarapi');
        }
        if (version_compare(VERSION, '2.2.0.0', ">=")) {
            $order_id = func_get_arg(2);
        }    
$this->log->write('KavenegarApi : $order_id =...'.$order_id);
$this->log->write('<pre> KavenegarApi : func_get_arg =...'.print_r(func_get_args(),true)."<pre>");
		
		
		if ($order_id == 0 || is_array($order_id)) {
			$order_id=$this->find_order_id($order_id);
		    if ($order_id == 0 || is_array($order_id)) {
				$this->log->write('KavenegarApi order_id is Null');
				return;
			}
        }
		
		
        $order_info = $this->model_checkout_order->getOrder($order_id);
        $kavenegarapi_setting = $this->model_setting_setting->getSetting('KavenegarApi', $order_info['store_id']);
       
		//Send SMS when the status order is changed
        if (isset($kavenegarapi_setting) 
		&& ($kavenegarapi_setting['KavenegarApi']['Enabled'] == 'yes') 
		&& ($kavenegarapi_setting['KavenegarApi']['OrderStatusChange']['Enabled'] == 'yes')) {
            $result = $this->db->query("SELECT count(*) as counter FROM " . DB_PREFIX . "order_history WHERE order_id = " . $order_id);
            if ($order_info['order_status_id'] && $result->row['counter'] > 1 
			&& (!empty($kavenegarapi_setting['KavenegarApi']['OrderStatusChange']['OrderStatus']) 
			&& (in_array($order_info['order_status_id'], $kavenegarapi_setting['KavenegarApi']['OrderStatusChange']['OrderStatus'])))) {
			
			$this->log->write("Send SMS when the status order is changed");
				
                if (isset($order_info['order_status']))
                    $Status = $order_info['order_status'];
                else
                    $Status = "";
                $language = $order_info['language_id'];
                $original = array(
                    "{SiteName}",
                    "{OrderID}",
                    "{Status}"
                );
                $replace  = array(
                    $this->config->get('config_name'),
                    $order_id,
                    $Status
                );                
                $message = str_replace($original, $replace, $kavenegarapi_setting['KavenegarApi']['OrderStatusChangeText'][$language]);
				if (!empty($order_info['telephone'])) {
					$phone = $order_info['telephone'];
				} else {
					$phone = $order_info['fax'];
				}
                try {
                    KavenegarApi::Send($kavenegarapi_setting['KavenegarApi']['APIKey'], $phone, $kavenegarapi_setting['KavenegarApi']['Sender'], $message);
                }
                catch (ApiException $ex) {
                    $this->log->write($ex->errorMessage());
                }
                catch (HttpException $ex) {
                    $this->log->write($ex->errorMessage());
                }
            }
        }
    }
	
    public function onRegister($customer_id, $data = 0)
    {           
        $this->log->write("Kavenegar: onRegister");

        if (!is_numeric($customer_id) && $data != 0) {
            $customer_id = $data;
        }
		
        $this->load->model('setting/setting');
        $kavenegarapi_setting = $this->model_setting_setting->getSetting('KavenegarApi', $this->config->get('store_id'));        
        if (version_compare(VERSION, '2.1.0.0', ">=") && version_compare(VERSION, '2.1.0.2', "<=")) {
            $this->load_library('kavenegarapi');
        } else {
            $this->load->library('kavenegarapi');
        } 
        $customer = $this->db->query("SELECT firstname,lastname,telephone FROM `" . DB_PREFIX . "customer` WHERE customer_id = " . (int) $customer_id);
        if ($customer->row) {
            $phone        = $customer->row['telephone'];
            $nameCustomer = $customer->row['firstname'] . " " . $customer->row['lastname'];
        } else {
            $phone        = '';
            $nameCustomer = '';
        }   
	
        //Send SMS to the user when the registration is successful
        if (isset($kavenegarapi_setting) && isset($kavenegarapi_setting['KavenegarApi']) 
		&& ($kavenegarapi_setting['KavenegarApi']['Enabled'] == 'yes') 
		&& (!empty($kavenegarapi_setting['KavenegarApi']['APIKey'])) 
		&& ($kavenegarapi_setting['KavenegarApi']['CustomerRegister']['Enabled'] == 'yes')) {
            $language = $this->config->get('config_language_id');
            $original = array(
                "{StoreName}",
                "{CustomerName}"
            );
            $replace  = array(
                $this->config->get('config_name'),
                $nameCustomer
            );            
            $message = str_replace($original, $replace, $kavenegarapi_setting['KavenegarApi']['CustomerRegisterText'][$language]);            
			$localid="1000".(string)$phone;		
            try {
                KavenegarApi::Send($kavenegarapi_setting['KavenegarApi']['APIKey'], $phone, $kavenegarapi_setting['KavenegarApi']['Sender'], $message,$localid);
            }
            catch (ApiException $ex) {
                $this->log->write($ex->errorMessage());
            }
            catch (HttpException $ex) {
                $this->log->write($ex->errorMessage());          
            } 
        }
		
		//Send SMS to the Admin when new user is registered		
        if (isset($kavenegarapi_setting) 
		&& isset($kavenegarapi_setting['KavenegarApi']) 
		&& ($kavenegarapi_setting['KavenegarApi']['Enabled'] == 'yes') 
		&& (!empty($kavenegarapi_setting['KavenegarApi']['APIKey'])) 
		&& ($kavenegarapi_setting['KavenegarApi']['AdminRegister']['Enabled'] == 'yes')) {
            $original = array(
                "{SiteName}",
                "{CustomerName}"
            );
            $replace  = array(
                $this->config->get('config_name'),
                $nameCustomer
            );
            $message  = str_replace($original, $replace, $kavenegarapi_setting['KavenegarApi']['AdminRegisterText']);
			$adminNumbers = array_map('trim', explode(',', $kavenegarapi_setting['KavenegarApi']['StoreOwnerPhoneNumber']));
			$lid=0;
            foreach ($adminNumbers as $adminNumber) {
                try {
				  	$localid="200".$lid.(string)$phone;
					$lid=$lid+1;
                    KavenegarApi::Send($kavenegarapi_setting['KavenegarApi']['APIKey'], $adminNumber, $kavenegarapi_setting['KavenegarApi']['Sender'], $message,$localid);
                }
                catch (ApiException $ex) {
					$this->log->write($ex->errorMessage());
                }
                catch (HttpException $ex) {
					$this->log->write($ex->errorMessage());
                }
            }	
        }
    }
     
    public function load_library($route)
    {
        $route = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string) $route);      
        $file  = DIR_SYSTEM . 'library/' . $route . '.php';
        $class = str_replace('/', '\\', $route);
        if (is_file($file)) {
            include_once($file);
            $this->registry->set(basename($route), new $class($this->registry));
        } else {
            throw new \Exception('Error: Could not load library ' . $route . '!');
        }
    }
   
	
	
}