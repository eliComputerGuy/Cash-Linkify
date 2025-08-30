@extends('layouts.dashboard-app')

@section('content')

<style>
  .video-list-scroll {
    max-height: 440px; /* ≈ 5 rows; adjust if your row height differs */
    overflow-y: auto;
  }
</style>

<div class="row">
    <!-- primary goal -->
    <div class="col-12 col-lg-12 col-xxl-4 mb-4 theme-teal">
        <div class="card adminuiux-card position-relative overflow-hidden bg-theme-1 h-100">
            <div class="position-absolute top-0 start-0 h-100 w-100 z-index-0 coverimg opacity-25">
                <img src="assets/img/modern-ai-image/tree-15.jpg" alt="">
            </div>
            <div class="card-body z-index-1">
                <div class="row align-items-center justify-content-center h-100 py-4">
                    <div class="col-11">
                        <h2 class="fw-normal">Your earnings today have grown by</h2>
                        <h1 class="mb-3">₦{{ number_format($totalEarningsToday, 2) }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--goals-->
    <div class="col-12 col-md-12 col-lg-8 mb-4">
        <div class="card adminuiux-card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h6>Videos Available Today</h6>
                    </div>
                    <div class="col-auto px-0">&nbsp;</div>
                    <div class="col-auto">&nbsp;</div>
                </div>
            </div>
            <ul class="list-group list-group-flush border-top bg-none {{ $videosToday->count() > 5 ? 'video-list-scroll' : '' }}">
                @if($videosToday->count())
                    @foreach($videosToday as $video)
                        <li class="list-group-item">
                            <div class="row gx-3 align-items-center">
                                <div class="col">
                                    <p class="mb-1 fw-medium">{{ $video->title }}</p>
                                    <p class="text-secondary small">Date: {{ $video->created_at->format('d F Y') }}</p>
                                </div>
                                <div class="col-auto text-end">
                                    <h6 class="text-success">₦ {{ number_format($rewardPerVideo, 2) }}</h6>
                                    <div class="badge badge-sm badge-light text-bg-warning">Active</div>
                                </div>
                                <div class="col-auto">
                                    <button
                                        class="avatar avatar-40 rounded-circle border border-theme-1 bg-theme-1-subtle text-theme-1"
                                        data-bs-toggle="modal"
                                        data-bs-target="#videoModal"
                                        data-id="{{ $video->id }}"
                                        data-title="{{ $video->title }}"
                                        data-url="{{ $video->url }}">
                                        <i class="bi bi-arrow-up-right h5"></i>
                                    </button>
                                </div>
                            </div>
                        </li>
                    @endforeach
                @else
                    <li class="list-group-item text-center">
                        <div class="row mb-4 mt-4">
                            <p class="text-muted">No videos available today.</p>
                        </div>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>

<!-- Video Modal -->
<div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="videoModalLabel">Video</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <!-- Let YouTube API create the iframe here -->
                <div id="youtubePlayer" style="width:100%;height:400px;"></div>
            </div>
        </div>
    </div>
</div>

<!-- CSRF meta (ensure this exists in your base layout <head>) -->
<!-- <meta name="csrf-token" content="{{ csrf_token() }}"> -->

<script src="https://www.youtube.com/iframe_api"></script>
<script>
let player;
let playerReady = false;
let currentVideoDbId = null;
let pendingVideoId = null;

// Robust extractor for YouTube video IDs
function getYouTubeId(url) {
    try {
        // Handle bare IDs
        if (/^[a-zA-Z0-9_-]{11}$/.test(url)) return url;

        const u = new URL(url);

        // watch?v=ID
        const vParam = u.searchParams.get('v');
        if (vParam) return vParam;

        // youtu.be/ID
        if (u.hostname.includes('youtu.be')) {
            const last = u.pathname.split('/').filter(Boolean).pop() || '';
            return last.split('?')[0];
        }

        // youtube.com/shorts/ID
        if (u.pathname.startsWith('/shorts/')) {
            const id = u.pathname.replace('/shorts/','').split('/')[0];
            return id.split('?')[0];
        }

        // youtube.com/embed/ID
        if (u.pathname.startsWith('/embed/')) {
            const id = u.pathname.replace('/embed/','').split('/')[0];
            return id.split('?')[0];
        }

        return null;
    } catch (e) {
        return null;
    }
}

// Called automatically when API is ready
function onYouTubeIframeAPIReady() {
    player = new YT.Player('youtubePlayer', {
        height: '400',
        width: '100%',
        playerVars: {
            // modest branding and API friendliness
            rel: 0,
            playsinline: 1,
            origin: window.location.origin
        },
        events: {
            'onReady': function () {
                playerReady = true;
                if (pendingVideoId) {
                    player.loadVideoById(pendingVideoId);
                    pendingVideoId = null;
                }
            },
            'onStateChange': onPlayerStateChange
        }
    });
}

function showToast(message, variant = 'info', delay = 4000) {
  const container = document.getElementById('toastContainer');
  const toastEl = document.createElement('div');

  const variantClass = {
    success: 'text-bg-success',
    warning: 'text-bg-warning',
    danger:  'text-bg-danger',
    info:    'text-bg-primary'
  }[variant] || 'text-bg-primary';

  const closeBtnClass = (variant === 'warning') ? 'btn-close' : 'btn-close-white';

  toastEl.className = `toast ${variantClass} border-0`;
  toastEl.setAttribute('role', 'alert');
  toastEl.setAttribute('aria-live', 'assertive');
  toastEl.setAttribute('aria-atomic', 'true');
  toastEl.innerHTML = `
    <div class="d-flex">
      <div class="toast-body">${message}</div>
      <button type="button" class="${closeBtnClass} me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  `;
  container.appendChild(toastEl);

  const t = new bootstrap.Toast(toastEl, { delay });
  t.show();
  toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
}

// Detect video end -> log earning
function onPlayerStateChange(event) {
    if (event.data === YT.PlayerState.ENDED && currentVideoDbId) {
        postEarning(currentVideoDbId)
            .then((data) => {
            if (data.status === 'success') {
                // alert('✅ Task earning logged!');
                showToast('✅ Task earning logged!', 'success');
            } else if (data.status === 'already_earned') {
                // alert('⚠️ You have already earned for this video today.');
                showToast('⚠️ You have already earned for this video today.', 'warning');
            } else {
                // alert('❌ Could not log earning.');
                showToast('❌ Could not log earning.', 'danger');
            }
            })
            .catch((err) => {
            // If you see "HTTP 419" here, it’s CSRF
            console.error('Earning POST failed:', err);
            // alert(`❌ Network error while logging earning: ${err.message}`);
            showToast(`❌ Network error while logging earning: ${err.message}`, 'danger');
        });
        // location.reload();
    }

}


function postEarning(videoId) {
  return fetch('/task/complete', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',                 // ask Laravel for JSON
      'X-Requested-With': 'XMLHttpRequest',        // tell Laravel it's AJAX
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify({ video_id: videoId })
  })
  .then(async (res) => {
    // Try to parse JSON; if it fails (e.g., HTML 419 page), throw a readable error
    let data = null;
    try { data = await res.json(); } catch (_) {}
    if (!res.ok) {
      const msg = (data && (data.message || data.error)) || `HTTP ${res.status}`;
      throw new Error(msg);
    }
    return data;
  });
}


document.addEventListener('DOMContentLoaded', function () {
    const videoModal = document.getElementById('videoModal');

    videoModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const videoUrl = button.getAttribute('data-url');
        currentVideoDbId = button.getAttribute('data-id');

        const ytId = getYouTubeId(videoUrl);
        if (!ytId) {
            alert('Invalid YouTube URL.');
            return;
        }

        if (playerReady) {
            player.loadVideoById(ytId);
        } else {
            pendingVideoId = ytId;
        }
    });

    videoModal.addEventListener('hidden.bs.modal', function () {
        if (playerReady) {
            try { player.stopVideo(); } catch (e) {}
        }
        currentVideoDbId = null;
        pendingVideoId = null;
    });
});
</script>

@endsection
