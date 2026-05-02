package com.example.bookstore.controller;

import com.example.bookstore.model.User;
import com.example.bookstore.model.Book;
import com.example.bookstore.repository.BookRepository;
import com.example.bookstore.repository.UserRepository;
import jakarta.servlet.http.HttpSession;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@Controller
public class BookstoreController {

    @Autowired BookRepository bookRepo;
    @Autowired UserRepository userRepo;

    @GetMapping("/")
    public String home(Model model) {
        model.addAttribute("books", bookRepo.findAll());
        return "home";
    }

    @GetMapping("/catalog")
    public String catalog(@RequestParam(required = false) String category, Model model) {
        List<Book> books = (category != null && !category.isEmpty())
            ? bookRepo.findByCategory(category)
            : bookRepo.findAll();
        model.addAttribute("books", books);
        model.addAttribute("category", category);
        return "catalog";
    }

    @GetMapping("/login")
    public String loginPage() { return "login"; }

    @PostMapping("/login")
    public String doLogin(@RequestParam String username,
                          @RequestParam String password,
                          HttpSession session, Model model) {
        var user = userRepo.findByUsername(username);
        if (user.isPresent() && user.get().getPassword().equals(password)) {
            session.setAttribute("loggedUser", username);
            return "redirect:/";
        }
        model.addAttribute("error", "Invalid credentials");
        return "login";
    }

    @GetMapping("/logout")
    public String logout(HttpSession session) {
        session.invalidate();
        return "redirect:/login";
    }

    @GetMapping("/register")
    public String registerPage() { return "register"; }

    @PostMapping("/register")
    public String doRegister(@RequestParam String username,
                             @RequestParam String password,
                             Model model) {
        if (userRepo.findByUsername(username).isPresent()) {
            model.addAttribute("error", "Username already taken.");
            return "register";
        }
        User user = new User();
        user.setUsername(username);
        user.setPassword(password);
        userRepo.save(user);
        return "redirect:/login";
    }
}
