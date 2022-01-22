<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Presentation\Console;

use Carbon\Carbon;

final class CommandTimer
{
    private const DATE_FORMAT = 'Y-m-d H:i:s.u';
    private Carbon $startedTime;
    private Carbon $stoppedTime;

    /**
     * CommandTimer constructor.
     * @param Carbon $startedTime
     * @param Carbon $stoppedTime
     */
    public function __construct(Carbon $startedTime, Carbon $stoppedTime)
    {
        $this->startedTime = $startedTime;
        $this->stoppedTime = $stoppedTime;
    }

    public function start(): void
    {
        $this->startedTime = $this->startedTime->now();
    }

    public function stop(): void
    {
        $this->stoppedTime = $this->stoppedTime->now();
    }

    /**
     * @return float
     */
    public function getTotalSeconds(): float
    {
        return $this->startedTime->floatDiffInSeconds($this->stoppedTime);
    }

    /**
     * @return string
     */
    public function getStartedTime(): string
    {
        return $this->startedTime->format(self::DATE_FORMAT);
    }

    /**
     * @return string
     */
    public function getStoppedTime(): string
    {
        return $this->stoppedTime->format(self::DATE_FORMAT);
    }
}
