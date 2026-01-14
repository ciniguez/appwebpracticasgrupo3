package com.controlador;

import java.io.IOException;
import java.util.List;

import com.modelo.entidades.Usuario;

import jakarta.servlet.ServletException;
import jakarta.servlet.annotation.WebServlet;
import jakarta.servlet.http.HttpServlet;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;
import com.modelo.dao.UsuarioDAO;

/**
 * Servlet implementation class GestionarUsuarioController
 */
@WebServlet("/GestionarUsuariosController")
public class GestionarUsuariosController extends HttpServlet {
	private static final long serialVersionUID = 1L;

    private UsuarioDAO usuarioDAO;
    public GestionarUsuariosController() {
    	this.usuarioDAO = new UsuarioDAO();
    }


	@Override
	protected void doGet(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {
		this.ruteador(req, resp);
	}

	@Override
	protected void doPost(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {
		this.ruteador(req, resp);
	}

	private void ruteador(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {
		String ruta = (req.getParameter("ruta") == null )? "listar": req.getParameter("ruta");
		

		switch (ruta) {
		case "listar":
			this.listar(req, resp);
			break;
		case "nuevo":
			this.nuevo(req, resp);
			break;
		case "actualizar":
			this.actualizar(req, resp);
			break;
		case "guardarnuevo":
			this.guardarNuevo(req, resp);
			break;
		case "guardarexistente":
			this.guardarExistente(req, resp);
			break;
		case "eliminar":
			this.eliminar(req, resp);
			break;
		default:
			this.listar(req, resp);
			break;
		}
	}
	
	private void listar(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {
		// 1.- Obtener los parámetros
		
		// 2.- Hablar con el modelo
		List<Usuario> personas =  this.usuarioDAO.getUsuarios();
		// 3.- Llamar a la vista
		req.setAttribute("personas", personas);
		req.getRequestDispatcher("jsp/listarusuarios.jsp").forward(req, resp);
	}

	private void nuevo(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {
		// 1.- Obtener los parámetros
		// 2.- Hablar con el modelo
		// 3.- Llamar a la vista
		resp.sendRedirect("jsp/crearusuario.jsp");
	}

	private void guardarNuevo(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {
	
		// 1.- Obtener los parámetros
		String nombre = req.getParameter("txtNombre");
		String clave = req.getParameter("txtClave");
		
		Usuario usuario = new Usuario(0, nombre, clave, false);
		// 2.- Hablar con el modelo
		boolean resultado = this.usuarioDAO.create(usuario);
		System.out.println(resultado);
		// 3.- Llamar a la vista
		if(resultado) {
			resp.sendRedirect("GestionarUsuariosController?ruta=listar");
		}else {
			req.setAttribute("mensaje", "No se pudo ingresar el usuario nuevo");
			req.getRequestDispatcher("jsp/error.jsp").forward(req, resp);
		}
	}

	private void actualizar(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {

		// 1.- Obtener los parámetros
		int idPersona = Integer.parseInt( req.getParameter("idpersona") );
		// 2.- Hablar con el modelo
		Usuario persona = this.usuarioDAO.getUsuarioById(idPersona);
		// 3.- Llamar a la vista
		req.setAttribute("persona", persona);
		req.getRequestDispatcher("jsp/actualizarusuario.jsp").forward(req, resp);
	}

	private void guardarExistente(HttpServletRequest req, HttpServletResponse resp)
			throws ServletException, IOException {
		// 1.- Obtener los parámetros
		int id = Integer.parseInt( req.getParameter("txtId"));
		String nombre = req.getParameter("txtNombre");
		String clave = req.getParameter("txtClave");
		
		Usuario usuario = new Usuario(id, nombre, clave, false);
		
		
		// 2.- Hablar con el modelo
		boolean respuesta = this.usuarioDAO.update(usuario);
		
		// 3.- Llamar a la vista
		if(respuesta) {
			resp.sendRedirect("GestionarUsuariosController?ruta=listar");
		}else {
			req.setAttribute("mensaje", "Error al actualizar el usuario con id: " + usuario.getId());
			req.getRequestDispatcher("jsp/error.jsp").forward(req, resp);
		}
		

	}

	private void eliminar(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {
		int idPersona = Integer.parseInt(req.getParameter("idPersona"));
		this.usuarioDAO.delete(idPersona);
		req.getRequestDispatcher("listarPersonasController").forward(req, resp);
	}
}
