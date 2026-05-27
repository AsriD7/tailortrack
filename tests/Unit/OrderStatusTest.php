<?php

namespace Tests\Unit;

use App\Enums\OrderStatus;
use PHPUnit\Framework\TestCase;

class OrderStatusTest extends TestCase
{
    public function test_tailor_can_choose_forward_progress_targets(): void
    {
        $targets = OrderStatus::Diproses->availableTailorProgressTargets();

        $this->assertSame([
            OrderStatus::Finishing,
            OrderStatus::SiapDiambil,
            OrderStatus::Selesai,
        ], $targets);
    }

    public function test_non_progress_status_has_no_tailor_progress_targets(): void
    {
        $this->assertSame([], OrderStatus::MenungguPembayaran->availableTailorProgressTargets());
        $this->assertSame([], OrderStatus::Selesai->availableTailorProgressTargets());
    }
}
