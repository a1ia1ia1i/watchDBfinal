db = db.getSiblingDB('watchdb');

db.watches.insertMany([
    { brand: "Rolex", model: "Daytona", price: 25000 },
    { brand: "Omega", model: "Speedmaster", price: 5000 },
    { brand: "Tag Heuer", model: "Carrera", price: 3500 },
    { brand: "Seiko", model: "Presage", price: 800 },
    { brand: "Casio", model: "G-Shock", price: 200 }
]);


