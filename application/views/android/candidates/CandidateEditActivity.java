
public class CandidateEditActivity extends AppCompatActivity {
	
	private text name;
				private text political_party;
				private EditText symbol;
				private EditText image;
				private Button btn_update_candidates;
	
	@Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        this.requestWindowFeature(Window.FEATURE_NO_TITLE);
        setContentView(R.layout.activity_edit_candidate);
		
		name = (text)findViewById(R.id.name);
				political_party = (text)findViewById(R.id.political_party);
				symbol = (EditText)findViewById(R.id.symbol);
				image = (EditText)findViewById(R.id.image);
				btn_edit_candidates = (Button)findViewById(R.id.btn_update_candidates);
		
		
		
		Intent intent = getIntent();
		String id = intent.getStringExtra("id");
		
		RequestQueue request_queue = Volley.newRequestQueue(CandidateEditActivity.this);
		StringRequest request = new StringRequest(Request.Method.POST, SERVER_URL+"/mobile/candidate/view_candidate/"+id, new Response.Listener<String>() {
								@Override
								public void onResponse(String server_response) {
								try {
                    			JSONArray JsonArray = new JSONArray(server_response);
								for(int i=0; i<=JsonArray.length(); i++){
									JSONObject json_object = JsonArray.getJSONObject(i);
									name.setText(json_object.getString("name"));
				political_party.setText(json_object.getString("political_party"));
				symbol.setText(json_object.getString("symbol"));
				image.setText(json_object.getString("image"));
				
			
								}
			
			
							} catch (JSONException e) {
								e.printStackTrace();
							 //   Toast.makeText(MainActivity.this, "error", Toast.LENGTH_SHORT).show();
							}
								}
							}, new Response.ErrorListener() {
								@Override
								public void onErrorResponse(VolleyError volleyError) {
								Toast.makeText(CandidateAddActivity.this, volleyError.toString(), Toast.LENGTH_SHORT).show();
								}
							}){
								@Override
								protected Map<String, String> getParams()  {
									HashMap<String,String> params = new HashMap<String,String>();
									return params;
								}
							};
							
				 request_queue.add(request);



	
btn_update_candidates.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
              final String form_name = name.getText().toString();
				final String form_political_party = political_party.getText().toString();
				final String form_symbol = symbol.getText().toString();
				final String form_image = image.getText().toString();
				
				
				RequestQueue request_queue = Volley.newRequestQueue(CandidateAddActivity.this); 
				 StringRequest request = new StringRequest(Request.Method.POST, url+"/mobile/candidate/save_data/"+form_candidate_id, new Response.Listener<String>() {
								@Override
								public void onResponse(String server_response) {
								Toast.makeText(CandidateAddActivity.this, server_response, Toast.LENGTH_SHORT).show();
								}
							}, new Response.ErrorListener() {
								@Override
								public void onErrorResponse(VolleyError volleyError) {
								Toast.makeText(CandidateAddActivity.this, volleyError.toString(), Toast.LENGTH_SHORT).show();
								}
							}){
								@Override
								protected Map<String, String> getParams()  {
									HashMap<String,String> params = new HashMap<String,String>();
									params.put("name", form_name);
				params.put("political_party", form_political_party);
				params.put("symbol", form_symbol);
				params.put("image", form_image);
				
									return params;
								}
							};
							
				 request_queue.add(request);
				
				
            }
        });
//end here .....
		
		
        
    }

}
