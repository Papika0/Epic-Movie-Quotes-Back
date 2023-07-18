<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
	public function index(int $page): JsonResponse
	{
		$user = User::findOrFail(auth()->user()->id);

		$unreadNotifications = $user->notifications()->where('read', 0)->count();

		$notifications = $user->notifications()
			->orderByDesc('created_at')
			->paginate(10, ['*'], 'page', $page);

		$remainingPages = $notifications->lastPage() - $notifications->currentPage();

		return response()->json(
			['data'                 => NotificationResource::collection($notifications),
				'pages_left'           => $remainingPages,
				'unread_notifications' => $unreadNotifications],
			200
		);
	}

	public function markAsRead(Notification $notification): JsonResponse
	{
		$notification->update(['read' => 1]);
		return response()->json(['message' => 'Notification marked as read', 'notification' => new NotificationResource($notification)], 200);
	}

	public function markAllAsRead(): JsonResponse
	{
		$user = User::findOrFail(auth()->user()->id);
		$user->notifications->where('read', 0)->each(function ($notification) {
			$notification->update(['read' => 1]);
		});
		return response()->json(['Notifications marked as read'], 200);
	}
}
