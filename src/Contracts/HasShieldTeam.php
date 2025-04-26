<?php

namespace ecoughtry\NovaShield\Contracts;

interface HasShieldTeam
{
    /**
     * Get the team id.
     *
     * @return int|string|null
     */
    public function getTeamIdAttribute(): mixed;
}
