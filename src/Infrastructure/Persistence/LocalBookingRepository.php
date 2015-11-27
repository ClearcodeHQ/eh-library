<?php

namespace Clearcode\EHLibrary\Infrastructure\Persistence;

use Clearcode\EHLibrary\Model\Booking;
use Clearcode\EHLibrary\Model\BookingRepository;

class LocalBookingRepository implements BookingRepository
{
    /** @var LocalStorage */
    private $storage;

    public function __construct()
    {
        $this->storage = LocalStorage::instance();
    }

    /** {@inheritdoc} */
    public function add(Booking $booking)
    {
        $this->storage->save('booking_'.uniqid().'_'.$booking->workerId(), $booking);
    }

    /** {@inheritdoc} */
    public function ofWorker($workerId)
    {
        $bookings = [];

        /** @var Booking $booking */
        foreach ($this->storage->find('booking_') as $booking) {
            if ($booking->workerId() == $workerId) {
                $bookings[] = $booking;
            }
        }

        return $bookings;
    }
}
