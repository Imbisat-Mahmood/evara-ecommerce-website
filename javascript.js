// Helper function: Toggle popup
function togglePopup(id) {
  document.querySelectorAll(".popup").forEach(p => p.style.display = "none");
  const popup = document.getElementById(id);
  if (popup) popup.style.display = "block";
}

// Search
document.getElementById("searchIcon").addEventListener("click", (e) => {
  e.preventDefault();
  togglePopup("searchBox");
});

// Profile
document.getElementById("profileIcon").addEventListener("click", (e) => {
  e.preventDefault();
  togglePopup("profileBox");
});

// Wishlist
document.getElementById("wishlistIcon").addEventListener("click", (e) => {
  e.preventDefault();
  togglePopup("wishlistBox");
});

// Cart
document.getElementById("cartIcon").addEventListener("click", (e) => {
  e.preventDefault();
  togglePopup("cartBox");
});

// Close popup when clicking outside
document.addEventListener("click", (e) => {
  if (!e.target.closest(".icons") && !e.target.closest(".popup")) {
    document.querySelectorAll(".popup").forEach(p => p.style.display = "none");
  }
});








const products = {
  1: {
    title: "12 Color Unlimited Writing Color Pencil",
    price: "Rs.495.00",
    img: "Stationary/colorful S.avif",
    description: "Unleash your creativity with the M&G Oil Pencil Colors Set...",
    specs: ["Wood Pencil Colors", "Hexagon Shape"],
    stock: "In Stock"
  },
  2: {
    title: "Transparent Pencil Case with Pens",
    price: "Rs.2,500.00 PKR",
    img: "images/kawai d.webp",
    description: "A bundle including a transparent pencil case with pens.",
    specs: ["Clear Design", "Comes with 5 pens"],
    stock: "Low Stock"
  }
};

// Get modal elements
const modal = document.getElementById("productModal");
const closeBtn = document.querySelector(".close-btn");

// Attach click event to each product card
document.querySelectorAll(".product-card").forEach((card, index) => {
  card.addEventListener("click", () => {
    const p = products[index+1]; // match card order
    document.getElementById("modal-title").innerText = p.title;
    document.getElementById("modal-price").innerText = p.price;
    document.getElementById("modal-img").src = p.img;
    document.getElementById("modal-description").innerText = p.description;
    document.getElementById("modal-specs").innerHTML = p.specs.map(s => `<li>${s}</li>`).join("");
    document.getElementById("modal-stock").innerText = p.stock;

    modal.style.display = "block";
  });
});

// Close modal
closeBtn.onclick = () => modal.style.display = "none";
window.onclick = (e) => { if (e.target == modal) modal.style.display = "none"; }
