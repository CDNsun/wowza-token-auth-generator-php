<?php

class TokenAuthGenerator {

    public $key     = null;
    public $allow   = array();
    public $deny    = array();
    public $expire  = null;

    public function setKey($key) 
    {
        $this->key = $key;
    }
    
    public function setExpire($expire) 
    {
        $this->expire = $expire;
    }
    
    public function setRefAllow(array $allow) 
    {
        $this->allow = $allow;
    }
    
    public function setRefDeny(array $deny) 
    {
        $this->deny = $deny;
    }

    private function pkcs5Pad($text, $blocksize) 
    {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }
    
    private function addRefAllowDeny($token)
    {
        $allow_domains = null;
        $deny_domains = null;                
        if(!empty($this->allow))
        {
            $allow_domains = implode(',', $this->allow);            
        }
        if(!empty($this->deny))
        {
            $deny_domains = implode(',', $this->deny);
        }        
        if(!empty($allow_domains) && !empty($deny_domains)) 
        {
            $token .= '&ref_allow=' . $allow_domains;
            $token .= '&ref_deny=' . $deny_domains;
        } 
        elseif(!empty($allow_domains)) 
        {
            $token .= '&ref_allow=' . $allow_domains;
        } 
        elseif(!empty($deny_domains)) 
        {
            $token .= '&ref_deny=' . $deny_domains;
        }
                
        return $token;
    }

    private function pkcs5Unpad($text) 
    {
        $pad = ord($text{strlen($text) - 1});
        if($pad > strlen($text))
        {
            return false;
        }
        if(strspn($text, chr($pad), strlen($text) - $pad) != $pad)
        {
            return false;
        }
        
        return substr($text, 0, -1 * $pad);
    }

    public function toString() 
    {                
        if($this->expire != null) 
        {
            $token = 'expire=' . $this->expire;
            $token = $this->addRefAllowDeny($token);
        } 
        else 
        {
            $token = '';
            $token = $this->addRefAllowDeny($token);
        }

        $blockSize = mcrypt_get_block_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
        $cipher = mcrypt_encrypt('blowfish', $this->key, $this->pkcs5Pad($token, $blockSize), 'ecb');
        $secure = sprintf('%s', bin2hex($cipher));

        return $secure;
    }    
}

?>
