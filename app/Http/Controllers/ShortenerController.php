<?php

namespace App\Http\Controllers;

use App\Models\ShortenedUrl;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Str;

class ShortenerController
{
    public function shorten(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'url' => 'required|url'
        ]);

        $shortenedUrl = ShortenedUrl::create([
            'user_id' => $request->user()->id,
            'url' => $validated['url'],
            'short_code' => Str::random(8),
            'expiration_date' => Carbon::now()->add('24 hours'),
        ]);

        return response()->json([
            'message' => 'Successfully shortened url',
            'link' => $shortenedUrl,
        ], 200);
    }

    public function links(Request $request): JsonResponse
    {
        return response()->json([
            'links' => ShortenedUrl::where('user_id', $request->user()->id)->get()
        ]);
    }

    public function visit($shortCode): JsonResponse
    {
        if (!is_string($shortCode)) {
            return response()->json([
                "error" => 'Short code not found'
            ], 404);
        }

        $shortenerUrl = ShortenedUrl::where('short_code', $shortCode)->first();

        if (!$shortenerUrl) {
            return response()->json([
                'message' => 'Shortened URL not found.',
            ], 404);
        }

        if ($shortenerUrl->expiration_date < now()) {
            return response()->json([
                'error' => 'The shortened URL has expired.',
            ], 410);
        }

        ShortenedUrl::where('short_code', $shortCode)
            ->update([
                'visit_count' => \DB::raw('visit_count + 1'),
                'last_visit' => now(),
            ]);

        return response()->json([
            'url' => $shortenerUrl['url']
        ]);
    }
}
