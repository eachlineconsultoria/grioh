<?php

// Pega thumbnail de YouTube/Vimeo
function get_video_thumbnail_url($video_url)
{
  if (!$video_url)
    return false;

  // YouTube
  if (strpos($video_url, 'youtu') !== false) {
    // tenta vários formatos (youtu.be/ID, v=ID, embed/ID)
    if (preg_match('~(?:youtu\.be/|v=|embed/)([A-Za-z0-9_-]{6,})~', $video_url, $m)) {
      $id = $m[1];
      return "https://img.youtube.com/vi/{$id}/hqdefault.jpg";
    }
  }

  // Vimeo
  if (strpos($video_url, 'vimeo.com') !== false) {
    if (preg_match('~vimeo\.com/(?:video/)?(\d+)~', $video_url, $m)) {
      $id = $m[1];
      $res = wp_remote_get("https://vimeo.com/api/v2/video/{$id}.json", ['timeout' => 6]);
      if (!is_wp_error($res)) {
        $body = json_decode(wp_remote_retrieve_body($res));
        if (!empty($body[0]->thumbnail_large))
          return $body[0]->thumbnail_large;
        if (!empty($body[0]->thumbnail_medium))
          return $body[0]->thumbnail_medium;
        if (!empty($body[0]->thumbnail_small))
          return $body[0]->thumbnail_small;
      }
    }
  }

  return false;
}
