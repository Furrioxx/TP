<?php

namespace Appy\Src\model;

enum Status
{
    case TODO;
    case ONGOING;
    case FINISHED;

    public function getValue()
    {
        return match ($this) {
            Status::TODO => 0,
            Status::ONGOING => 1,
            Status::FINISHED => 2,
        };
    }
}
