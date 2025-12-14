

<div class="container-lg p-8 mt-3">
    <div class="flex flex-col lg:flex-row gap-4 min-h-screen">
        <div class="w-full lg:w-1/3">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
              <div class="p-4 border-b border-gray-200">
                    <h3 class="font-semibold text-gray-800">เส้นทาง</h3>
                </div>
                <div class="overflow-y-auto h-128 md:h-80 lg:h-[600px]">
                    <div id="branchList" class="p-4 space-y-3"></div>
                </div>
            </div>
        </div>

        <div class="flex-1">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-4 border-b border-gray-200">
                    <h3 class="font-semibold text-gray-800">แผนที่</h3>
                </div>
                <div class="relative">
                    <iframe id="mapFrame" 
                            class="w-full border-0 h-64 md:h-80 lg:h-[800px]" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade"
                            src="">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const branches = [
    {
        name: "คณะเทคโนโลยีสารสนเทศ ม.ราชภัฏเพชรบุรี",
        lat: 13.074277438147556,
        lng: 99.97813952820123,
        img: "https://demo.mucity.online/img/PBRU3.jpg",
        subdistrict: "นาวุ้ง",
        district: "เมืองเพชรบุรี",
        province: "เพชรบุรี",
        zipcode: "76000",
        distance: 0
    }
];

function calcDistance(lat1, lon1, lat2, lon2) {
    const R = 6371; // รัศมีโลก (กม.)
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(lat1 * Math.PI / 180) *
        Math.cos(lat2 * Math.PI / 180) *
        Math.sin(dLon / 2) * Math.sin(dLon / 2);
    return R * (2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a)));
}

function renderBranches(data) {
    const branchList = document.getElementById("branchList");
    branchList.innerHTML = "";
    data.forEach(branch => {
        const div = document.createElement("div");
        div.className = "branch-item p-4 bg-white border-2 border-gray-200 hover:bg-gray-50 rounded-lg cursor-pointer transition-colors duration-200";
        div.innerHTML = `
        <div class="mb-3">
                <img src="${branch.img}" 
                     alt="${branch.name}" 
                     class="w-full h-40 object-cover rounded-lg shadow-sm">
            </div>
            <div class="flex justify-between items-start mb-1">
                <h4 class="text-lg font-semibold text-gray-800 flex-1 mr-2">${branch.name}</h4>
                <span class="text-xs text-white bg-sky-500 px-2 py-2 rounded-full whitespace-nowrap">${branch.distance.toFixed(2)} กม.</span>
            </div>
            <div class="text-sm text-gray-600 mb-3 leading-relaxed">
                📍 ${branch.subdistrict}, ${branch.district}<br>${branch.province} ${branch.zipcode}
            </div>
            <button onclick="showMap(${branch.lat}, ${branch.lng}); event.stopPropagation();" 
                class="w-full bg-sky-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-sky-600 transition-colors duration-200 flex items-center justify-center gap-2">
                <span>🗺️</span><span>ดูแผนที่</span>
            </button>
        `;
        branchList.appendChild(div);
    });
}

function showMap(lat, lng) {
    document.getElementById("mapFrame").src = `https://www.google.com/maps?q=${lat},${lng}&output=embed`;
}
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
        position => {
            const userLat = position.coords.latitude;
            const userLng = position.coords.longitude;
            branches.forEach(branch => {
                branch.distance = calcDistance(userLat, userLng, branch.lat, branch.lng);
            });
            branches.sort((a, b) => a.distance - b.distance);

            renderBranches(branches);
            if (branches.length > 0) {
                showMap(branches[0].lat, branches[0].lng);
            }
        },
        error => {
            Swal.fire({
                icon: 'error',
                title: 'ไม่สามารถเข้าถึงตำแหน่งได้',
                text: 'กรุณาเปิดการแชร์ตำแหน่ง (Location) แล้วลองใหม่อีกครั้ง',
                confirmButtonText: 'ตกลง',
                confirmButtonColor: '#3085d6'
            });
            renderBranches(branches);
        }
    );
} else {
    Swal.fire({
        icon: 'warning',
        title: 'เบราว์เซอร์ไม่รองรับ',
        text: 'เบราว์เซอร์ของคุณไม่รองรับการระบุตำแหน่ง',
        confirmButtonText: 'เข้าใจแล้ว',
        confirmButtonColor: '#f59e0b'
    });
    renderBranches(branches);
}
</script>
