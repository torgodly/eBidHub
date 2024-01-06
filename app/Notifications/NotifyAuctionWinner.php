<?php

namespace App\Notifications;

use App\Models\Auction;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class NotifyAuctionWinner extends Notification
{
    use Queueable;

    public $auction;

    /**
     * Create a new notification instance.
     */
    public function __construct(Auction $auction)
    {
        $this->auction = $auction;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $auctionTitle = $this->auction->title;
        $auctionOwnerName = $this->auction->creator->name; // Assuming there is a 'user' relationship on Auction model

        return (new MailMessage)
            ->greeting('تهانينا!')
            ->line('أنت الفائز في مزاد "' . $auctionTitle . '"!')
            ->line('نحن متحمسون لإعلامك أن مزايدتك كانت الأعلى، ولقد حققت النصر.')
            ->line('إليك التفاصيل:')
            ->line('المزاد: **' . $auctionTitle . '**')
            ->line('أعلى مزايدة: **' . number_format($this->auction->end_price) . '**') // قم بتعديلها واستخدم دالة لتنسيق العملة
            ->line('كود التأكيد:')
            ->line(new HtmlString('<table border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse;width:max-content;margin-top:20px;margin-bottom:20px"><tbody><tr><td style="font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding:14px 32px 14px 32px;background-color:#f2f2f2;border-left:1px solid #ccc;border-right:1px solid #ccc;border-top:1px solid #ccc;border-bottom:1px solid #ccc;text-align:center;border-radius:7px;display:block;border:1px solid #1877f2;background:#e7f3ff"><span class="m_-8063385560543524649mb_text" style="font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:16px;line-height:21px;color:#141823"><span style="font-size:17px;font-family:Roboto;font-weight:700;margin-left:0px;margin-right:0px">' . $this->auction->winner_code . '</span></span></td></tr></tbody></table>'))
            ->line('استخدم هذا الرمز للمطالبة بفوزك!')
            ->line('انقر [هنا](' . route('auctions.show', $this->auction->id) . ') لعرض تفاصيل المزاد.')
            ->line('شكرًا لمشاركتك، واستمتع بجائزتك!')
            ->salutation('أطيب التحيات');
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
