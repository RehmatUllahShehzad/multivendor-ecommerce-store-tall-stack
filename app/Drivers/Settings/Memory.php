<?php

namespace App\Drivers\Settings;

use App\Contracts\SettingDriver;

class Memory extends SettingDriver
{
    /**
     * @param  array  $data
     */
    public function __construct(array $data = null)
    {
        if ($data) {
            $this->data = $data;
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function getExtraColumns()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    protected function read()
    {
        return $this->data;
    }

    /**
     * {@inheritdoc}
     */
    protected function write(array $data)
    {
        // do nothing
    }
}
