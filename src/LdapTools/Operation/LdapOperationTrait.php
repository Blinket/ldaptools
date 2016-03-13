<?php
/**
 * This file is part of the LdapTools package.
 *
 * (c) Chad Sikorra <Chad.Sikorra@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LdapTools\Operation;

use LdapTools\Connection\LdapControl;

/**
 * Common LDAP operation functions.
 *
 * @author Chad Sikorra <Chad.Sikorra@gmail.com>
 */
trait LdapOperationTrait
{
    /**
     * @var null|string
     */
    protected $server;

    /**
     * @var LdapControl[]
     */
    protected $controls = [];

    /**
     * @var LdapOperationInterface[]
     */
    protected $preOperations = [];

    /**
     * @var LdapOperationInterface[]
     */
    protected $postOperations = [];

    /**
     * Set the LDAP server that should be used for the operation.
     *
     * @param string|null $server
     * @return $this
     */
    public function setServer($server)
    {
        $this->server = $server;

        return $this;
    }

    /**
     * Get the server that should be used for the operation.
     *
     * @return null|string
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * Get the controls set for the operation.
     *
     * @return LdapControl[]
     */
    public function getControls()
    {
        return $this->controls;
    }

    /**
     * Add a control to the operation.
     *
     * @param LdapControl $control
     * @return $this
     */
    public function addControl(LdapControl $control)
    {
        $this->controls[] = $control;

        return $this;
    }

    /**
     * Add an operation that should be executed before this operation.
     *
     * @param LdapOperationInterface[] ...$operation
     * @return $this
     */
    public function addPreOperation(LdapOperationInterface ...$operations)
    {
        foreach ($operations as $operation) {
            $this->preOperations[] = $operation;
        }

        return $this;
    }

    /**
     * Get operations that should be executed before this operation.
     *
     * @return LdapOperationInterface[]
     */
    public function getPreOperations()
    {
        return $this->preOperations;
    }

    /**
     * Add an operation that should be executed after this operation.
     *
     * @param LdapOperationInterface[] ...$operation
     * @return $this
     */
    public function addPostOperation(LdapOperationInterface ...$operations)
    {
        foreach ($operations as $operation) {
            $this->postOperations[] = $operation;
        }

        return $this;
    }

    /**
     * Get operations that should be executed after this operation.
     *
     * @return LdapOperationInterface[]
     */
    public function getPostOperations()
    {
        return $this->postOperations;
    }

    /**
     * Merges the log array with common log properties.
     *
     * @param array $log
     * @return array
     */
    protected function mergeLogDefaults(array $log)
    {
        $controls = [];
        if (!empty($this->controls)) {
            foreach ($this->controls as $control) {
                $controls[] = $control->toArray();
            }
        }

        return array_merge($log, [
            'Server' => $this->server,
            'Controls' => var_export($controls, true),
        ]);
    }
}
