package controlador;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

import jakarta.servlet.ServletException;
import jakarta.servlet.annotation.WebServlet;
import jakarta.servlet.http.HttpServlet;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;
import modelo.Persona;

@WebServlet("/Capulina")
public class MiServlet extends HttpServlet{

	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;

	@Override
	protected void doGet(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {
	
		
		System.out.println("Hola, la solicitud ingresó por GET");
		List<Persona> personas = new ArrayList<>();
		personas.add(new Persona ("Carlos", "Iniguez","123456789"));
		personas.add(new Persona ("Juan", "Ruales","123454445"));
		personas.add(new Persona ("Pedro", "Rodriguez","123444449"));
		personas.add(new Persona ("Maria", "Elinor","123567789"));
		
		req.setAttribute("personitas", personas);
		
		req.getRequestDispatcher("vistas/mivista.jsp").forward(req, resp);
	}

	@Override
	protected void doPost(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {
		System.out.println("Hola, la solicitud ingresó por POST");
	}
	
	

}
