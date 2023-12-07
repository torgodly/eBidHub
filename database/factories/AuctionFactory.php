<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Auction>
 */
class AuctionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'title' => $this->faker->sentence,
            'info' => [
                'color' => $this->faker->colorName,
                'size' => $this->faker->randomElement(['S', 'M', 'L', 'XL']),
            ],
            'about' => $this->faker->paragraph,
            'description' => "# Elegant Vintage Wristwatch

This exquisite vintage wristwatch combines timeless elegance with superior craftsmanship. Perfect for collectors and fashion enthusiasts alike.

## Features
- **Brand**: Timeless Classics
- **Year**: Circa 1950s
- **Condition**: Fully restored, excellent working condition
- **Material**: 18k gold casing with leather strap
- **Movement**: Mechanical hand-wind

## Description
A stunning piece from the 1950s, this wristwatch by Timeless Classics is a testament to the era's sophistication. The watch has been fully restored to its original glory. The casing is crafted from high-quality 18k gold, paired with a durable and comfortable leather strap. The mechanical hand-wind movement ensures reliability and precision.

### Dimensions
- **Dial Diameter**: 40mm
- **Strap Length**: 9 inches

### Additional Information
- Comes with a certificate of authenticity.
- A one-year warranty is included.
- Free shipping worldwide.

## Terms and Conditions
- **Starting Bid**: $2,000
- **Auction Duration**: 7 days from the listing date.
- **Payment Methods**: Credit Card, PayPal, Bank Transfer.
- **Returns**: Accepted within 14 days of purchase (conditions apply).

---

**Note**: This item is a vintage piece and has been restored to the best of our abilities. However, minor signs of wear and age are inherent characteristics that add to its charm and historical value.

For any inquiries or to arrange a viewing appointment, please contact us at contact@example.com.
",
            'price' => $this->faker->numberBetween(100, 10000),
            'end' => $this->faker->dateTimeBetween('+1 week', '+2 week'),
            'user_id' => 21,
            'minimum_bid' => 10
        ];
    }
}
