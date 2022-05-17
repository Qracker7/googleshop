<?php

namespace App\Http;

use Alexusmai\LaravelFileManager\Services\ACLService\ACLRepository;
use File;
use App\Domain;
use App\Models\Template;

class CustomACLRepository implements ACLRepository
{
    /**
     * Get user ID
     *
     * @return mixed
     */
    public function getUserID()
    {
        return seller_id();
    }

    /**
     * Get ACL rules list for user
     *
     * @return array
     */
    public function getRules(): array
    {
        $domain = Domain::find(\Auth::user()->domain_id);
        $template = Template::find($domain->template_id);
        
        $arr = explode('/', $template->src_path);
        $template_name = $arr[count($arr) - 1];
        
        return [
            ['disk' => 'custom_template', 'path' => '/', 'access' => 1],
            ['disk' => 'custom_template', 'path' => $this->getUserID(), 'access' => 1],
            ['disk' => 'custom_template', 'path' => $this->getUserID().'/'.$template_name, 'access' => 1],
            ['disk' => 'custom_template', 'path' => $this->getUserID().'/'.$template_name.'/*', 'access' => 2],
            ['disk' => 'custom_asset', 'path' => '/', 'access' => 1],
            ['disk' => 'custom_asset', 'path' => $this->getUserID(), 'access' => 1],
            ['disk' => 'custom_asset', 'path' => $this->getUserID().'/'.$template_name, 'access' => 1],
            ['disk' => 'custom_asset', 'path' => $this->getUserID().'/'.$template_name.'/css', 'access' => 1],
            ['disk' => 'custom_asset', 'path' => $this->getUserID().'/'.$template_name.'/css/*', 'access' => 2],
        ];
    }
}