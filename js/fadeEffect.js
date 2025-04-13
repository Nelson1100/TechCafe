const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        console.log(entry)
        if (entry.isIntersecting) {
            entry.target.classList.add('show');
            observer.unobserve(entry.target);
        } else {
            entry.target.classList.remove('show');
        }
    });
});

const hiddenElements = document.querySelectorAll('.hidden1'); 
hiddenElements.forEach((el) => observer.observe(el));

const hiddenelement = document.querySelectorAll('.hidden2'); 
hiddenelement.forEach((el) => observer.observe(el));