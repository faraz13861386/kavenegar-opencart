<?php
    class ControllerExtensionModuleKavenegarApi extends Controller
    {
        private $data = array();
        private $version = "1.0.1";
        public function install()
        {
            $this->load->model('extension/module/kavenegarapi');
            $this->model_extension_module_kavenegarapi->install();
        }
        public function uninstall()
        {
            $this->load->model('extension/module/kavenegarapi');
            $this->model_extension_module_kavenegarapi->uninstall();
        }
        private function getCatalogURL()
        {
            if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
                $storeURL = HTTPS_CATALOG;
            } else {
                $storeURL = HTTP_CATALOG;
            }
            return $storeURL;
        }
        private function getServerURL()
        {
            if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
                $storeURL = HTTPS_SERVER;
            } else {
                $storeURL = HTTP_SERVER;
            }
            return $storeURL;
        }
        private function getCurrentStore($store_id)
        {
            if ($store_id && $store_id != 0) {
                $store = $this->model_setting_store->getStore($store_id);
            } else {
                $store['store_id'] = 0;
                $store['name'] = $this->config->get('config_name');
                $store['url'] = $this->getCatalogURL();
            }
            return $store;
        }
        public function index()
        {
            $this->load->language('extension/module/kavenegarapi');
            $this->load->model('extension/module/kavenegarapi');
            $this->load->model('setting/store');
            $this->load->model('localisation/language');
            $this->load->model('design/layout');
            $this->load->model('tool/image');
            $this->load->model('setting/setting');
            $catalogURL = $this->getCatalogURL();
            $this->data['catalogURL'] = $catalogURL;
            $this->document->addStyle('view/stylesheet/extension/module/kavenegarapi/kavenegarapi.css');
            $this->document->addScript('view/javascript/extension/module/kavenegarapi/kavenegarapi.js');
            $this->document->addScript('view/javascript/extension/module/kavenegarapi/smscounter.js');
            $this->document->setTitle($this->language->get('heading_title'));
            if (!isset($this->request->get['store_id'])) {
                $this->request->get['store_id'] = 0;
            }
            $store = $this->getCurrentStore($this->request->get['store_id']);
            if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                if (!$this->user->hasPermission('modify', 'extension/module/kavenegarapi')) {
                    $this->session->data['error'] = 'You do not have permissions to edit this module!';
                    $this->error['warning'] = $this->language->get('error_permission');
                } else {
                    $this->model_setting_setting->editSetting('KavenegarApi', $this->request->post, $this->request->post['store_id']);
                    $this->session->data['success'] = $this->language->get('text_success');
                }
                $this->response->redirect(HTTP_SERVER.'index.php?route=extension/module/kavenegarapi&store_id='.$this->request->post['store_id'] . '&token=' . $this->session->data['token']);
            }
            $this->data['image'] = 'no_image.jpg';
            $this->data['thumb'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
            $this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);

            if (isset($this->session->data['success'])) {
                $this->data['success'] = $this->session->data['success'];
                unset($this->session->data['success']);
            } else {
                $this->data['success'] = '';
            }

            if (isset($this->error['warning'])) {
                $this->data['error_warning'] = $this->error['warning'];
            } else {
                $this->data['error_warning'] = '';
            }
            $this->load->model('localisation/order_status');
            $this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

            $this->data['breadcrumbs']   = array();
            $this->data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            );
            $this->data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_module'),
                'href' => $this->url->link('extension/extension/module', 'token=' . $this->session->data['token'], 'SSL'),
            );
            $this->data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('extension/module/kavenegarapi', 'token=' . $this->session->data['token'], 'SSL'),
            );
            $languageVariables = array(
                'entry_code',
                'heading_title',
                'error_input_form',
                'entry_yes',
                'entry_no',
                'text_default',
                'text_enabled',
                'text_disabled',
                'text_text',
                'save_changes',
                'button_cancel',
                'text_settings',
                'button_add',
                'button_edit',
                'button_remove',
                'text_special_duration'
            );
            foreach ($languageVariables as $languageVariable) {
                $this->data[$languageVariable] = $this->language->get($languageVariable);
            }
            $this->data['stores'] = array_merge(array(0 => array('store_id' => '0', 'name' => $this->config->get('config_name') . ' ' . $this->data['text_default'], 'url' => HTTP_SERVER, 'ssl' => HTTPS_SERVER)), $this->model_setting_store->getStores());
            $this->data['error_warning']          = '';
            $this->data['languages']              = $this->model_localisation_language->getLanguages();
            $this->data['store']                  = $store;
            $this->data['token']                  = $this->session->data['token'];
            $this->data['action']                 = $this->url->link('extension/module/kavenegarapi', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['saveApiKey']             = $this->url->link('extension/module/kavenegarapi/saveApiKey', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['cancel']                 = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['data']                   = $this->model_setting_setting->getSetting('kavenegarapi', $store['store_id']);
            $this->data['catalog_url']            = $catalogURL;
            if (strcmp(VERSION, "2.1.0.1") < 0) {
                $this->load->model('sale/customer_group');
                $this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups(0);
            } else {
                $this->load->model('customer/customer_group');
                $this->data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups(0);
            }

            if (!empty($_SERVER['HTTP_REFERER'])) {
                $referer = $_SERVER['HTTP_REFERER'];
                $url = parse_url($referer);

                if (!empty($url['host']) && strpos($url['host'], 'paypal.com') !== false) {
                    $this->data['success'] = 'The payment has been sent! You may need to wait several minutes for your account balance to be updated.';
                }
            }
            $this->data['remaincredit']  =0;
            $this->data['header']  					 = $this->load->controller('common/header');
            $this->data['column_left']				= $this->load->controller('common/column_left');
            $this->data['footer']					 = $this->load->controller('common/footer');
            $this->response->setOutput($this->load->view('extension/module/kavenegarapi.tpl', $this->data));
        }
        public function send()
        {
            $json = array(
                'return'=>array(
                'status'=>0,
                'message'=>''
            )
            );
            if ($this->request->server['REQUEST_METHOD'] == 'POST') {
                if (!$this->user->hasPermission('modify', 'extension/module/kavenegarapi')) {
                    $json['return']['status'] = 0;
                    $json['return']['message'] = 'You do not have permission to perform this action!';
                    return $this->response->setOutput(json_encode($json));
                }
                if (!$this->request->post['message']) {
                    $json['return']['status'] = 0;
                    $json['return']['message'] = 'متن پیام خالی است';
                    return $this->response->setOutput(json_encode($json));
                }
                $this->load->model('setting/store');

                $this->load->model('extension/module/kavenegarapi');

                if (isset($this->request->get['page'])) {
                    $page = $this->request->get['page'];
                } else {
                    $page = 1;
                }

                $receptors = array();
                switch ($this->request->post['to']) {
                    case 'telephones':
                        $phones = isset($this->request->post['phones']) ? $this->request->post['phones'] : array();
                        foreach ($phones as $result) {
                            $receptors[] = $this->model_extension_module_kavenegarapi->formatNumber($result);
                        }
                        break;
                    case 'newsletter':
                        $customer_data = array(
                            'filter_newsletter' => 1,
                            'start'             => ($page - 1) * 10
                        );
                        $telephones_total = $this->model_extension_module_kavenegarapi->getTotalCustomers($customer_data);
                        $results = $this->model_extension_module_kavenegarapi->getCustomers($customer_data);
                        foreach ($results as $result) {
                            $receptors[] = $this->model_extension_module_kavenegarapi->formatNumber($result['telephone']);
                        }
                        break;
                    case 'customer_all':
                        $customer_data = array(
                            'start'  => ($page - 1) * 10
                        );
                        $telephones_total = $this->model_extension_module_kavenegarapi->getTotalCustomers($customer_data);
                        $results = $this->model_extension_module_kavenegarapi->getCustomers($customer_data);
                        foreach ($results as $result) {
                            $receptors[] = $this->model_extension_module_kavenegarapi->formatNumber($result['telephone']);
                        }
                        break;
                    case 'customer_group':
                        $customer_data = array(
                            'filter_customer_group_id' => $this->request->post['customer_group_id'],
                            'start'                    => ($page - 1) * 10
                        );
                        $telephones_total = $this->model_extension_module_kavenegarapi->getTotalCustomers($customer_data);
                        $results = $this->model_extension_module_kavenegarapi->getCustomers($customer_data);
                        foreach ($results as $result) {
                            $receptors[] = $this->model_extension_module_kavenegarapi->formatNumber($result['telephone']);
                        }
                        break;
                    case 'customer':
                        if (!empty($this->request->post['customer'])) {
                            foreach ($this->request->post['customer'] as $customer_id) {
                                $customer_info = $this->model_extension_module_kavenegarapi->getCustomer($customer_id);
                                if ($customer_info) {
                                    $receptors[] = $this->model_extension_module_kavenegarapi->formatNumber($customer_info['telephone']);
                                }
                            }
                        }
                        break;
                    case 'affiliate_all':
                        $affiliate_data = array(
                            'start'  => ($page - 1) * 10
                        );
                        $telephones_total = $this->model_extension_module_kavenegarapi->getTotalAffiliates($affiliate_data);
                        $results = $this->model_extension_module_kavenegarapi->getAffiliates($affiliate_data);
                        foreach ($results as $result) {
                            $receptors[] = $this->model_extension_module_kavenegarapi->formatNumber($result['telephone']);
                        }
                        break;
                    case 'affiliate':
                        if (!empty($this->request->post['affiliate'])) {
                            foreach ($this->request->post['affiliate'] as $affiliate_id) {
                                $affiliate_info = $this->model_extension_module_kavenegarapi->getAffiliate($affiliate_id);
                                if ($affiliate_info) {
                                    $receptors[] = $this->model_extension_module_kavenegarapi->formatNumber($affiliate_info['telephone']);
                                }
                            }
                        }
                        break;
                    case 'product':
                        if (isset($this->request->post['product'])) {
                            $results = $this->model_extension_module_kavenegarapi->getTelephonesByProductsOrdered($this->request->post['product'], ($page - 1) * 10, 10);
                            foreach ($results as $result) {
                                $receptors[] = $this->model_extension_module_kavenegarapi->formatNumber($result['telephone']);
                            }
                        }
                        break;
                }
                if (version_compare(VERSION, '2.1.0.0', ">=") && version_compare(VERSION, '2.1.0.2', "<=")) {
                    $this->load_library('kavenegarapi');
                } else {
                    $this->load->library('kavenegarapi');
                }
                $this->load->model('setting/setting');
                $kavenegarapi = $this->model_setting_setting->getSetting('KavenegarApi', $this->config->get('config_store_id'));
                try {
                    $resultJosn=kavenegarapi::send(
                        $kavenegarapi['KavenegarApi']['APIKey'],
                        implode(",", $receptors),
                        $kavenegarapi['KavenegarApi']['Sender'],
                        $this->request->post['message']
                    );

                    return $this->response->setOutput(json_encode($resultJosn));
                } catch (ApiException $e) {
                    $json['return']['status']=0;
                    $json['return']['message']=$e->errorMessage();
                    return $this->response->setOutput(json_encode($json));
                } catch (HttpException $e) {
                    $json['return']['status']=0;
                    $json['return']['message']=$e->errorMessage();
                    return $this->response->setOutput(json_encode($json));
                }
            }
            $json['return']['status'] = 0;
            $json['return']['message'] = 'متن پیام خالی است';
            return $this->response->setOutput(json_encode($json));
        }
        public function load_library($route)
        {
            // Sanitize the call
            $route = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route);

            $file = DIR_SYSTEM . 'library/' . $route . '.php';
            $class = str_replace('/', '\\', $route);
            if (is_file($file)) {
                include_once($file);
                $this->registry->set(basename($route), new $class($this->registry));
            } else {
                throw new \Exception('Error: Could not load library ' . $route . '!');
            }
        }
        public function remaincredit()
        {
            $json = array(
                'return'=>array(
                'status'=>0,
                'message'=>''
            )
            );
            if ($this->request->server['REQUEST_METHOD'] == 'POST') {
                if (!$this->user->hasPermission('modify', 'module/kavenegarapi')) {
                    $json['return']['status'] = 0;
                    $json['return']['message'] = 'You do not have permission to perform this action!';
                    return $this->response->setOutput(json_encode($json));
                }
                $this->load->library('kavenegarapi');
                $this->load->model('setting/setting');
                $kavenegarapi_setting = $this->model_setting_setting->getSetting('KavenegarApi', $this->config->get('config_store_id'));
                try {
                    $resultJosn=KavenegarApi::AccountInfo($kavenegarapi_setting['KavenegarApi']['APIKey']);
                    return $this->response->setOutput(json_encode($resultJosn));
                } catch (ApiException $e) {
                    $json['return']['status']=0;
                    $json['return']['message']=$e->errorMessage();
                    return $this->response->setOutput(json_encode($json));
                } catch (HttpException $e) {
                    $json['return']['status']=0;
                    $json['return']['message']=$e->errorMessage();
                    return $this->response->setOutput(json_encode($json));
                }
            }
            $json['return']['status'] = 0;
            $json['return']['message'] = 'متن پیام خالی است';
            return $this->response->setOutput(json_encode($json));
        }
    }
?>   