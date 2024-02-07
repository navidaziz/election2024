
public class CandidateAddActivity extends AppCompatActivity {
	
	private text name;
				private text political_party;
				private EditText symbol;
				private EditText image;
				private Button btn_add_candidates;
	
	@Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        this.requestWindowFeature(Window.FEATURE_NO_TITLE);
        setContentView(R.layout.activity_add_candidate);
		
		name = (text)findViewById(R.id.name);
				political_party = (text)findViewById(R.id.political_party);
				symbol = (EditText)findViewById(R.id.symbol);
				image = (EditText)findViewById(R.id.image);
				btn_add_candidates = (Button)findViewById(R.id.btn_add_candidates);
		
		
btn_add_candidates.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                //do your code here
				final String form_name = name.getText().toString();
				final String form_political_party = political_party.getText().toString();
				final String form_symbol = symbol.getText().toString();
				final String form_image = image.getText().toString();
				
				
				RequestQueue request_queue = Volley.newRequestQueue(CandidateAddActivity.this); 
				 StringRequest request = new StringRequest(Request.Method.POST, SERVER_URL+"/mobile/candidate/save_data", new Response.Listener<String>() {
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
