<?php

namespace App\Http\Controllers\notification;

use App\Http\Controllers\Controller;
use App\Http\Resources\Notification\NotificationResource;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
	public function getNotifications(int $page): JsonResponse
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
				'unread_notifications' => $unreadNotifications]
		);
	}

	public function markAsRead(Notification $id): JsonResponse
	{
		$id->update(['read' => 1]);
		return response()->json(['message' => 'Notification marked as read', 'notification' => new NotificationResource($id)]);
	}

	public function markAllAsRead(): JsonResponse
	{
		$user = User::findOrFail(auth()->user()->id);
		$user->notifications->where('read', 0)->each(function ($notification) {
			$notification->update(['read' => 1]);
		});
		return response()->json(['Notifications marked as read']);
	}
}
