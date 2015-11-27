<?php

namespace Clearcode\EHLibrary\Model;

interface BookingRepository
{
    /**
     * @param Booking $booking
     */
    public function add(Booking $booking);

    /**
     * @param int $workerId
     *
     * @throws \LogicException
     *
     * @return Booking[]
     */
    public function ofWorker($workerId);
}
