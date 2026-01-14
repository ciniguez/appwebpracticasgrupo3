package com.recursos;

import java.util.List;



import com.modelo.dao.DAOFactory;
import com.modelo.entidades.Usuario;


import jakarta.ws.rs.Consumes;
import jakarta.ws.rs.DELETE;
import jakarta.ws.rs.GET;
import jakarta.ws.rs.POST;
import jakarta.ws.rs.PUT;
import jakarta.ws.rs.Path;
import jakarta.ws.rs.PathParam;
import jakarta.ws.rs.Produces;
import jakarta.ws.rs.core.MediaType;



@Path("/personas")
public class RecursoPersona {

		@GET
		@Produces(MediaType.APPLICATION_JSON)
		public List<Usuario> getPersonas(){
			return DAOFactory.getFactory().getPersonaDAO().get();
		}
		
		@GET
		@Path("/{id}")
		@Produces(MediaType.APPLICATION_XML)
		public Usuario getPeronaPorId(@PathParam("id") int id) {
			Usuario p = DAOFactory.getFactory().getPersonaDAO().getById(id);
			return p;
		}
		
		@POST
		@Path("/add")
		@Consumes(MediaType.APPLICATION_XML)
		@Produces(MediaType.APPLICATION_JSON)
		public boolean guardarPersona(Usuario p) {
			DAOFactory.getFactory().getPersonaDAO().create(p);
			return true;
		}
		
		@PUT
		@Path("/update")
		@Consumes(MediaType.APPLICATION_JSON)
		@Produces(MediaType.APPLICATION_JSON)
		public boolean actualizarPersona(Usuario p) {
			DAOFactory.getFactory().getPersonaDAO().update(p);
			return true;
		}
		
		@DELETE
		@Path("/delete/{id}")
		@Produces(MediaType.APPLICATION_JSON)
		public boolean eliminarPersona (@PathParam("id")   int id) {
			DAOFactory.getFactory().getPersonaDAO().deleteByID(id);
			return true;
		}
		
}
