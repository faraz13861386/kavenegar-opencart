<?php 
    class ModelExtensionModuleKavenegarApi extends Model
    {
        public static function KavenegarApiCallback($response)
        {
            global $log;

            if ($response->return->status != '200') {
                $log->write('KavenegarApi: '.$response->return->message);
            }
        }

        public function formatNumber($number)
        {
            return $number;
        }

        public function install()
        {
            $this->load->model('extension/event');
            $this->model_extension_event->addEvent("kavenegarapi", 'catalog/controller/checkout/success/before', 'extension/module/kavenegarapi/onCheckout');
            $this->model_extension_event->addEvent("kavenegarapi", 'catalog/model/checkout/order/addOrderHistory/after', 'extension/module/kavenegarapi/onHistoryChange');
            $this->model_extension_event->addEvent("kavenegarapi", 'catalog/model/account/customer/addCustomer/after', 'extension/module/kavenegarapi/onRegister');
        }
        public function uninstall()
        {
            $this->load->model('setting/setting');

            $this->load->model('setting/store');
            $this->model_setting_setting->deleteSetting('kavenegarapi_module', 0);
            $stores=$this->model_setting_store->getStores();
            foreach ($stores as $store) {
                $this->model_setting_setting->deleteSetting('kavenegarapi_module', $store['store_id']);
            }
            $this->load->model('extension/event');
            $this->model_extension_event->deleteEvent('kavenegarapi');
        }

        public function getTotalCustomers($data = array())
        {
            $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer";
            $implode = array();
            if (!empty($data['filter_name'])) {
                $implode[] = "CONCAT(firstname, ' ', lastname) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
            }
            if (!empty($data['filter_email'])) {
                $implode[] = "email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
            }
            if (isset($data['filter_newsletter']) && !is_null($data['filter_newsletter'])) {
                $implode[] = "newsletter = '" . (int)$data['filter_newsletter'] . "'";
            }
            if (!empty($data['filter_customer_group_id'])) {
                $implode[] = "customer_group_id = '" . (int)$data['filter_customer_group_id'] . "'";
            }
            if (!empty($data['filter_ip'])) {
                $implode[] = "customer_id IN (SELECT customer_id FROM " . DB_PREFIX . "customer_ip WHERE ip = '" . $this->db->escape($data['filter_ip']) . "')";
            }
            if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
                $implode[] = "status = '" . (int)$data['filter_status'] . "'";
            }
            if (isset($data['filter_approved']) && !is_null($data['filter_approved'])) {
                $implode[] = "approved = '" . (int)$data['filter_approved'] . "'";
            }
            if (!empty($data['filter_date_added'])) {
                $implode[] = "DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
            }
            if ($implode) {
                $sql .= " WHERE " . implode(" AND ", $implode);
            }
            $query = $this->db->query($sql);
            return $query->row['total'];
        }

        public function getCustomers($data = array())
        {
            $sql = "SELECT *, CONCAT(c.firstname, ' ', c.lastname) AS name, cgd.name AS customer_group FROM " . DB_PREFIX . "customer c LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (c.customer_group_id = cgd.customer_group_id) WHERE cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
            $implode = array();
            if (!empty($data['filter_name'])) {
                $implode[] = "CONCAT(c.firstname, ' ', c.lastname) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
            }
            if (!empty($data['filter_email'])) {
                $implode[] = "c.email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
            }
            if (isset($data['filter_newsletter']) && !is_null($data['filter_newsletter'])) {
                $implode[] = "c.newsletter = '" . (int)$data['filter_newsletter'] . "'";
            }
            if (!empty($data['filter_customer_group_id'])) {
                $implode[] = "c.customer_group_id = '" . (int)$data['filter_customer_group_id'] . "'";
            }
            if (!empty($data['filter_ip'])) {
                $implode[] = "c.customer_id IN (SELECT customer_id FROM " . DB_PREFIX . "customer_ip WHERE ip = '" . $this->db->escape($data['filter_ip']) . "')";
            }
            if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
                $implode[] = "c.status = '" . (int)$data['filter_status'] . "'";
            }
            if (isset($data['filter_approved']) && !is_null($data['filter_approved'])) {
                $implode[] = "c.approved = '" . (int)$data['filter_approved'] . "'";
            }
            if (!empty($data['filter_date_added'])) {
                $implode[] = "DATE(c.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
            }
            if ($implode) {
                $sql .= " AND " . implode(" AND ", $implode);
            }
            $sort_data = array(
                'name',
                'c.email',
                'customer_group',
                'c.status',
                'c.approved',
                'c.ip',
                'c.date_added'
            );
            if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
                $sql .= " ORDER BY " . $data['sort'];
            } else {
                $sql .= " ORDER BY name";
            }
            if (isset($data['order']) && ($data['order'] == 'DESC')) {
                $sql .= " DESC";
            } else {
                $sql .= " ASC";
            }
            $query = $this->db->query($sql);
            return $query->rows;
        }

        public function getCustomer($customer_id)
        {
            $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "'");
            return $query->row;
        }

        public function getTotalAffiliates($data = array())
        {
            $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "affiliate";
            $implode = array();
            if (!empty($data['filter_name'])) {
                $implode[] = "CONCAT(firstname, ' ', lastname) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
            }
            if (!empty($data['filter_email'])) {
                $implode[] = "LCASE(email) = '" . $this->db->escape(utf8_strtolower($data['filter_email'])) . "'";
            }
            if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
                $implode[] = "status = '" . (int)$data['filter_status'] . "'";
            }
            if (isset($data['filter_approved']) && !is_null($data['filter_approved'])) {
                $implode[] = "approved = '" . (int)$data['filter_approved'] . "'";
            }
            if (!empty($data['filter_date_added'])) {
                $implode[] = "DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
            }
            if ($implode) {
                $sql .= " WHERE " . implode(" AND ", $implode);
            }
            $query = $this->db->query($sql);
            return $query->row['total'];
        }

        public function getAffiliates($data = array())
        {
            $sql = "SELECT *, CONCAT(a.firstname, ' ', a.lastname) AS name, (SELECT SUM(at.amount) FROM " . DB_PREFIX . "affiliate_transaction at WHERE at.affiliate_id = a.affiliate_id GROUP BY at.affiliate_id) AS balance FROM " . DB_PREFIX . "affiliate a";
            $implode = array();
            if (!empty($data['filter_name'])) {
                $implode[] = "CONCAT(a.firstname, ' ', a.lastname) LIKE '" . $this->db->escape($data['filter_name']) . "%'";
            }
            if (!empty($data['filter_email'])) {
                $implode[] = "LCASE(a.email) = '" . $this->db->escape(utf8_strtolower($data['filter_email'])) . "'";
            }
            if (!empty($data['filter_code'])) {
                $implode[] = "a.code = '" . $this->db->escape($data['filter_code']) . "'";
            }
            if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
                $implode[] = "a.status = '" . (int)$data['filter_status'] . "'";
            }
            if (isset($data['filter_approved']) && !is_null($data['filter_approved'])) {
                $implode[] = "a.approved = '" . (int)$data['filter_approved'] . "'";
            }
            if (!empty($data['filter_date_added'])) {
                $implode[] = "DATE(a.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
            }
            if ($implode) {
                $sql .= " WHERE " . implode(" AND ", $implode);
            }
            $sort_data = array(
                'name',
                'a.email',
                'a.code',
                'a.status',
                'a.approved',
                'a.date_added'
            );
            if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
                $sql .= " ORDER BY " . $data['sort'];
            } else {
                $sql .= " ORDER BY name";
            }
            if (isset($data['order']) && ($data['order'] == 'DESC')) {
                $sql .= " DESC";
            } else {
                $sql .= " ASC";
            }
            $query = $this->db->query($sql);
            return $query->rows;
        }

        public function getAffiliate($affiliate_id)
        {
            $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "affiliate WHERE affiliate_id = '" . (int)$affiliate_id . "'");
            return $query->row;
        }

        public function getTotalTelephonesByProductsOrdered($products)
        {
            $implode = array();
            foreach ($products as $product_id) {
                $implode[] = "op.product_id = '" . (int)$product_id . "'";
            }
            $query = $this->db->query("SELECT DISTINCT telephone FROM `" . DB_PREFIX . "order` o LEFT JOIN " . DB_PREFIX . "order_product op ON (o.order_id = op.order_id) WHERE (" . implode(" OR ", $implode) . ") AND o.order_status_id <> '0'");
            return $query->row['total'];
        }

        public function getTelephonesByProductsOrdered($products, $start, $end)
        {
            $implode = array();
            foreach ($products as $product_id) {
                $implode[] = "op.product_id = '" . (int)$product_id . "'";
            }
            $query = $this->db->query("SELECT DISTINCT telephone FROM `" . DB_PREFIX . "order` o LEFT JOIN " . DB_PREFIX . "order_product op ON (o.order_id = op.order_id) WHERE (" . implode(" OR ", $implode) . ") AND o.order_status_id <> '0' LIMIT " . (int)$start . "," . (int)$end);
            return $query->rows;
        }
    }
?>