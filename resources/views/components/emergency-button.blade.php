<div class="emergency-button fixed-bottom text-end mb-4 me-4">
    <a href="{{ route('user.emergency-request.create') }}" 
       class="btn btn-danger btn-lg rounded-circle shadow-lg"
       title="Emergency Help">
        <i class="fas fa-exclamation-triangle fa-2x"></i>
    </a>
</div>

<style>
.emergency-button {
    z-index: 9999;
}
.emergency-button a {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: pulse 2s infinite;
}
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}
</style>