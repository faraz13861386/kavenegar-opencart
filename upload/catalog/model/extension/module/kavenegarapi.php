<?php
    class ModelExtensionModuleKavenegarApi extends Model
    {
        public function getSetting($group, $store_id)
        {
            $data = array();
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `group` = '" . $this->db->escape($group) . "'");
            foreach ($query->rows as $result) {
                if (!$result['serialized']) {
                    $data[$result['key']] = $result['value'];
                } else {
                    $data[$result['key']] = unserialize($result['value']);
                }
            }
            return $data;
        }

        public static function logger($response=null)
        {
            if ($response!=null && is_object($response)) {
                global $log;
                $log->write('KavenegarApi['.$response->return->status.']: '.$response->return->message);
            }
        }

        public function formatNumber($number)
        {
            return $number;
        }
    }
?>